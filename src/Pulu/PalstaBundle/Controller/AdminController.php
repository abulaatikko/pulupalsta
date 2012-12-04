<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\ArticleLocalization;
use Pulu\PalstaBundle\Form\Type\ArticleType;
use Pulu\PalstaBundle\Entity\Tag;
use Pulu\PalstaBundle\Entity\TagLocalization;
use Pulu\PalstaBundle\Form\Type\TagType;
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
            $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->find($id);
        }
        $defaultArticleNumber = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findNextArticleNumber();
        $form = $this->createForm(new ArticleType(), $article, array('default_article_number' => $defaultArticleNumber));

        if ($R->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $delete = $R->get('delete');
            if ($delete) {
                $article->setDeleted();
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Artikkeli poistettu');
                return $this->redirect($this->generateUrl('pulu_palsta_admin_article'));
            }
            $form->bind($R);
            if ($form->isValid()) {                
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Artikkeli tallennettu');
            } else {
                $this->get('session')->getFlashBag()->add('error', 'Artikkelin tallennus epäonnistui');
            }

            if (! $id > 0) {
                return $this->redirect($this->generateUrl('pulu_palsta_admin_article_edit', array('id' => $article->getId())));
            }
        }

        return $this->render('PuluPalstaBundle:Admin:handleArticle.html.php', array(
            'form' => $form->createView(),
            'article' => $article
        ));
    }

    public function listCommentAction() {
        $repository = $this->getDoctrine()->getManager()->getRepository('PuluPalstaBundle:Comment');
        $comments = $repository->findByCreated();

        return $this->render('PuluPalstaBundle:Admin:comment.html.php', array(
            'comments' => $comments
        ));
    }

    public function listTagAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Tag');
        $tags = $repository->findAllOrderedByName();

        return $this->render('PuluPalstaBundle:Admin:tag.html.php', array(
            'tags' => $tags
        ));
    }

    public function handleTagAction($id = null) {
        $R = $this->get('request');
        if (empty($id)) {
            $tag = new Tag();
            $tagLocalizationFI = new TagLocalization();
            $tagLocalizationFI->setLanguage('fi');
            $tagLocalizationFI->setTag($tag);
            $tagLocalizationEN = new TagLocalization();
            $tagLocalizationEN->setLanguage('en');
            $tagLocalizationEN->setTag($tag);
            $tag->getLocalizations()->add($tagLocalizationFI);
            $tag->getLocalizations()->add($tagLocalizationEN);
        } else {
            $tag = $this->getDoctrine()->getRepository('PuluPalstaBundle:Tag')->find($id);
        }
        $form = $this->createForm(new TagType(), $tag);

        if ($R->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tag);
            $delete = $R->get('delete');
            if ($delete) {
                //$tag->setDeleted();
                //$em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Asiasana poistettu');
                return $this->redirect($this->generateUrl('pulu_palsta_admin_tag'));
            }
            $form->bind($R);
            if ($form->isValid()) {                
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Asiasana tallennettu');
            } else {
                $this->get('session')->getFlashBag()->add('error', 'Asiasanan tallennus epäonnistui');
            }

            if (! $id > 0) {
                return $this->redirect($this->generateUrl('pulu_palsta_admin_tag_edit', array('id' => $tag->getId())));
            }
        }

        return $this->render('PuluPalstaBundle:Admin:handleTag.html.php', array(
            'form' => $form->createView(),
            'tag' => $tag
        ));
    }

}