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
use Symfony\Component\Form\Form;

class AdminController extends Controller {

    public function indexAction() {
        return $this->render('PuluPalstaBundle:Admin:index.html.php');
    }

    public function listArticleAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $articles = $repository->findAllOrderedByName();

        return $this->render('PuluPalstaBundle:Admin:article.html.php', array(
            'articles' => $articles
        ));
    }

    public function handleArticleAction($id = null) {
        $R = $this->get('request');
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
        $form = $this->createForm(new ArticleType(), $article, array(
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
                    } else {                        
                        break;
                    }
                }
                $em->flush();

                $articleManager = new ArticleManager($article);
                $articleManager->setEntityManager($em);
                $articleManager->saveRevision();

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

    public function historyArticleAction($id) {
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findOneBy(array('id' => $id, 'deleted' => null));
        $articleManager = new ArticleManager($article);
        $revisions = $articleManager->getRevisionsByRevision('desc');

        $R = $this->get('request');
        $requestRevision = $R->get('revision');
        $revisionsData = array();
        if (! empty($requestRevision)) {            
            $nameFI = $articleManager->getPropertyByRevision('getName', 'fi', $requestRevision);
            $teaserFI = $articleManager->getPropertyByRevision('getTeaser', 'fi', $requestRevision);
            $bodyFI = $articleManager->getPropertyByRevision('getBody', 'fi', $requestRevision);
            $nameEN = $articleManager->getPropertyByRevision('getName', 'en', $requestRevision);
            $teaserEN = $articleManager->getPropertyByRevision('getTeaser', 'en', $requestRevision);
            $bodyEN = $articleManager->getPropertyByRevision('getBody', 'en', $requestRevision);
            $revisionsData = array(
                'name' => array(
                    'fi' => $nameFI,
                    'en' => $nameEN
                ),
                'teaser' => array(
                    'fi' => $teaserFI,
                    'en' => $teaserEN
                ),
                'body' => array(
                    'fi' => $bodyFI,
                    'en' => $bodyEN
                ),
                'revision' => $requestRevision,
                'created' 
            );
        }

        return $this->render('PuluPalstaBundle:Admin:historyArticle.html.php', array(
            'article' => $article,
            'revisions' => $revisions,
            'revision' => $revisionsData
        ));
    }

    public function listCommentAction() {
        $repository = $this->getDoctrine()->getManager()->getRepository('PuluPalstaBundle:Comment');
        $comments = $repository->findByCreated();

        return $this->render('PuluPalstaBundle:Admin:comment.html.php', array(
            'comments' => $comments
        ));
    }

    public function handleCommentAction($id = null) {
        $R = $this->get('request');
        if (empty($id)) {
            $comment = new Comment();
        } else {
            $comment = $this->getDoctrine()->getRepository('PuluPalstaBundle:Comment')->findOneBy(array('id' => $id, 'deleted' => null));
        }
        $form = $this->createForm(new AdminCommentType(), $comment);

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

    public function handleKeywordAction($id = null) {
        $R = $this->get('request');
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
        $form = $this->createForm(new KeywordType(), $keyword);

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


}
