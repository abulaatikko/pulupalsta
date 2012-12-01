<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\Comment;
use Pulu\PalstaBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller {

    public function viewAction($id, $name) {
        $R = $this->get('request');
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->find($id);

        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment);

        return $this->render('PuluPalstaBundle:Article:view.html.php', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }

    public function redirectAction($id) {
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->find($id);
        $name = $article->getName($this->getRequest()->getLocale());
        $name = $this->get('helper')->toFilename($name);

        return $this->redirect($this->generateUrl('pulu_palsta_article', array('id' => $id, 'name' => $name)), 301);
    }


}
