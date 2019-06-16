<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\ArticleLocalization;
use Pulu\PalstaBundle\Manager\ArticleManager;
use Pulu\PalstaBundle\Form\Type\ArticleType;
use Pulu\PalstaBundle\Entity\Keyword;
use Pulu\PalstaBundle\Entity\KeywordLocalization;
use Pulu\PalstaBundle\Entity\ArticleKeyword;
use Pulu\PalstaBundle\Form\Type\KeywordType;
use Pulu\PalstaBundle\Form\Type\AdminCommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;

class AdminController extends Controller {

    public function indexAction() {
        return $this->render('PuluPalstaBundle:Admin:index.html.php');
    }

    public function listArticleAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $articles = $repository->findOrderedByPublished(99999);

        return $this->render('PuluPalstaBundle:Admin:article.html.php', array(
            'articles' => $articles,
            'articleTypes' => [
                Article::TYPE_UNDEFINED => '',
                Article::TYPE_EXPEDITION => 'Expedition',
                Article::TYPE_RESEARCH => 'Research',
                Article::TYPE_ART => 'Art',
                Article::TYPE_ESSAY => 'Essay'
            ]
        ));
    }

    public function handleArticleAction(Request $R, $id = null) {
        if (empty($id)) {
            $article = new Article();
            $articleLocalizationFI = new ArticleLocalization();
            $articleLocalizationFI->setLanguage('fi');
            $articleLocalizationFI->setArticle($article);
            $articleLocalizationEN = new ArticleLocalization();
            $articleLocalizationEN->setLanguage('en');
            $articleLocalizationEN->setArticle($article);
            $article->getLocalizations()->add($articleLocalizationFI);
            $article->getLocalizations()->add($articleLocalizationEN);
        } else {
            $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findOneBy(array('id' => $id, 'deleted' => null));
        }

        $defaultArticleNumber = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findNextArticleNumber();
        $availableKeywords = $this->getDoctrine()->getRepository('PuluPalstaBundle:Keyword')->findAllOrderedByName();
        $form = $this->createForm(ArticleType::class, $article, array(
            'default_article_number' => $defaultArticleNumber,
            'available_keywords' => $availableKeywords
        ));

        if ($R->isMethod('POST')) {
            $article->setModified();
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);

            $delete = $R->get('delete');
            if ($delete) {
                $article->setDeleted();
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Artikkeli poistettu');
                return $this->redirect($this->generateUrl('pulu_palsta_admin_article'));
            }

            $form->handleRequest($R);
            if ($form->isValid()) {
                $requestData = $R->get('article');
                // Article keywords
                $currentKeywords = $article->getKeywords();
                foreach ($currentKeywords as $currentKeyword) {
                    $em->remove($currentKeyword);
                }
                for ($i = 0; $i <= 100; $i++) {
                    $keyword_id_key = 'keyword_' . $i . '_id';
                    $keyword_weight_key = 'keyword_' . $i . '_weight';
                    if (isset($requestData[$keyword_id_key]) && ! empty($requestData[$keyword_id_key])) {
                        $keyword_id = $requestData[$keyword_id_key];
                        $keyword = $this->getDoctrine()->getRepository('PuluPalstaBundle:Keyword')->find($keyword_id);
                        $articleKeyword = new ArticleKeyword();
                        $articleKeyword->setArticle($article);
                        $articleKeyword->setKeyword($keyword);
                        if (isset($requestData[$keyword_weight_key])) {
                            $articleKeyword->setWeight($requestData[$keyword_weight_key]);
                        }
                        $em->persist($articleKeyword);
                    }
                }
                $em->flush();

                $articleManager = new ArticleManager($article);
                $articleManager->setEntityManager($em);
                $articleManager->saveRevision();
                $articleManager->saveModifiedPublic();

                $this->get('session')->getFlashBag()->add('notice', 'Artikkeli tallennettu');
            } else {
                $this->get('session')->getFlashBag()->add('error', 'Artikkelin tallennus epäonnistui');
            }

            return $this->redirect($this->generateUrl('pulu_palsta_admin_article_edit', array('id' => $article->getId())));
        }

        return $this->render('PuluPalstaBundle:Admin:handleArticle.html.php', array(
            'form' => $form->createView(),
            'article' => $article
        ));
    }

    public function historyArticleAction(Request $R, $id) {
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findOneBy(array('id' => $id, 'deleted' => null));
        $articleManager = new ArticleManager($article);
        $revisions = $articleManager->getRevisionsByRevision('desc');

        $requestRevision = $R->get('revision');
        $language = $R->get('language');
        $revisionData = array();

        if (! empty($requestRevision) && ! empty($language)) {
            $name = $articleManager->getPropertyByRevision('getName', $language, $requestRevision);
            $teaser = $articleManager->getPropertyByRevision('getTeaser', $language, $requestRevision);
            $body = $articleManager->getPropertyByRevision('getBody', $language, $requestRevision);
         
            $revisionData = array(
                'name' => $name,
                'teaser' => $teaser,
                'body' => $body,
                'revision' => $requestRevision,
                'created' => null
            );
        }

        return $this->render('PuluPalstaBundle:Admin:historyArticle.html.php', array(
            'article' => $article,
            'revisions' => $revisions,
            'revision' => $revisionData,
            'language' => $language
        ));
    }

    public function diffArticleAction(Request $R, $id) {
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findOneBy(array('id' => $id, 'deleted' => null));
        $articleManager = new ArticleManager($article);
        $em = $this->getDoctrine()->getManager();
        $articleManager->setEntityManager($em);

        $requestRevision = $R->get('revision');
        $language = $R->get('language');

        $nameDiff = $articleManager->getPropertyDiff('getName', $language, $requestRevision);
        $teaserDiff = $articleManager->getPropertyDiff('getTeaser', $language, $requestRevision);
        $bodyDiff = $articleManager->getPropertyDiff('getBody', $language, $requestRevision);

        return $this->render('PuluPalstaBundle:Admin:diffArticle.html.php', array(
            'diff_name' => $nameDiff,
            'diff_teaser' => $teaserDiff,
            'diff_body' => $bodyDiff,
        ));
    }

    public function listCommentAction() {
        $repository = $this->getDoctrine()->getManager()->getRepository('PuluPalstaBundle:Comment');
        $comments = $repository->findByCreated();

        return $this->render('PuluPalstaBundle:Admin:comment.html.php', array(
            'comments' => $comments
        ));
    }

    public function handleCommentAction(Request $R, $id = null) {
        if (empty($id)) {
            $comment = new Comment();
        } else {
            $comment = $this->getDoctrine()->getRepository('PuluPalstaBundle:Comment')->findOneBy(array('id' => $id, 'deleted' => null));
        }
        $form = $this->createForm(AdminCommentType::class, $comment);

        if ($R->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $delete = $R->get('delete');
            if ($delete) {
                $comment->setDeleted();
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Kommentti poistettu');
                return $this->redirect($this->generateUrl('pulu_palsta_admin_comment'));
            }
            $form->handleRequest($R);
            if ($form->isValid()) {                
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Kommentti tallennettu');
            } else {
                $this->get('session')->getFlashBag()->add('error', 'Kommentin tallennus epäonnistui');
            }

            if (! $id > 0) {
                return $this->redirect($this->generateUrl('pulu_palsta_admin_comment_edit', array('id' => $comment->getId())));
            }
        }

        return $this->render('PuluPalstaBundle:Admin:handleComment.html.php', array(
            'form' => $form->createView(),
            'comment' => $comment
        ));
    }

    public function listKeywordAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Keyword');
        $keywords = $repository->findAllOrderedByName();

        return $this->render('PuluPalstaBundle:Admin:keyword.html.php', array(
            'keywords' => $keywords
        ));
    }

    public function handleKeywordAction(Request $R, $id = null) {
        if (empty($id)) {
            $keyword = new Keyword();
            $keywordLocalizationFI = new KeywordLocalization();
            $keywordLocalizationFI->setLanguage('fi');
            $keywordLocalizationFI->setKeyword($keyword);
            $keywordLocalizationEN = new KeywordLocalization();
            $keywordLocalizationEN->setLanguage('en');
            $keywordLocalizationEN->setKeyword($keyword);
            $keyword->getLocalizations()->add($keywordLocalizationFI);
            $keyword->getLocalizations()->add($keywordLocalizationEN);
        } else {
            $keyword = $this->getDoctrine()->getRepository('PuluPalstaBundle:Keyword')->find($id);
        }
        $form = $this->createForm(KeywordType::class, $keyword);

        if ($R->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($keyword);
            $delete = $R->get('delete');
            if ($delete) {
                $keywordLocalizations = $keyword->getLocalizations();
                foreach ($keywordLocalizations as $keywordLocalization) {
                    $em->remove($keywordLocalization);
                }
                $em->remove($keyword);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Avainsana poistettu');
                return $this->redirect($this->generateUrl('pulu_palsta_admin_keyword'));
            }
            $form->handleRequest($R);
            if ($form->isValid()) {                
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Avainsana tallennettu');
            } else {
                $this->get('session')->getFlashBag()->add('error', 'Avainsanan tallennus epäonnistui');
            }

            if (! $id > 0) {
                return $this->redirect($this->generateUrl('pulu_palsta_admin_keyword_edit', array('id' => $keyword->getId())));
            }
        }

        return $this->render('PuluPalstaBundle:Admin:handleKeyword.html.php', array(
            'form' => $form->createView(),
            'keyword' => $keyword
        ));
    }

    public function guideAction() {
        return $this->render('PuluPalstaBundle:Admin:guide.html.php');
    }

    public function visitAction() {
        return $this->render('PuluPalstaBundle:Admin:visit.html.php');
    }

    public function visitAverageAction() {
        return $this->render('PuluPalstaBundle:Admin:visit_average.html.php');
    }

}
