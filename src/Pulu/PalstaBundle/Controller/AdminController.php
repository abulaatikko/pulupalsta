<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\ArticleLocalization;
use Pulu\PalstaBundle\Form\Type\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class AdminController extends Controller {

    public function indexAction() {
        return $this->render('PuluPalstaBundle:Admin:index.html.php');
    }

    public function articleAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $articles = $repository->createQueryBuilder('A')->innerJoin('A.localizations', 'B')->orderBy('B.name', 'ASC')->getQuery()->getResult();

        return $this->render('PuluPalstaBundle:Admin:article.html.php', array(
            'articles' => $articles
        ));
    }

    public function createArticleAction(Request $request) {
        $article = new Article();

        /*$form = $this->createFormBuilder($article)
            ->add('name', 'text', array(
                'label' => 'Nimi',
                'required' => true
            ))
            ->add('teaser', 'text', array(
                'label' => 'Houkutusteksti',
                'required' => false
            ))
            ->getForm();*/

        $form = $this->createForm(new ArticleType(), $article);

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                //$article->setPoints(1);
                //$article->setVisits(0);
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Your changes were saved!');//die(var_dump($this->get('session')->getFlashBag()->get('notice')));
                return $this->redirect($this->generateUrl('pulu_palsta_admin_article_edit', array('id' => $article->getId())));
            }
        }


        return $this->render('PuluPalstaBundle:Admin:createArticle.html.php', array(
            'form' => $form->createView()
        ));
    }

    public function editArticleAction($id = null) {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $article = $repository->find($id);

        return $this->render('PuluPalstaBundle:Admin:editArticle.html.php', array(
                'article' => $article
        ));
    }

}
