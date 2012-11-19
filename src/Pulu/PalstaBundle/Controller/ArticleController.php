<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller {

    public function viewAction($id, $name) {
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->find($id);

        return $this->render('PuluPalstaBundle:Article:view.html.php', array(
            'article' => $article
        ));
    }

    public function redirectAction($id) {
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->find($id);
        $name = $article->getName($this->getRequest()->getLocale());
        $name = $this->get('helper')->toFilename($name);

        return $this->redirect($this->generateUrl('pulu_palsta_article', array('id' => $id, 'name' => $name)), 301);
    }


}
