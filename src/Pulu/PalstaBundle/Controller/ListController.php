<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListController extends Controller {
    public function indexAction(Request $R) {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $repository->setLanguage($R->getLocale());
        $articles = $repository->findOrderedByPublishedForPublic(10000);
        return $this->render('PuluPalstaBundle:List:index.html.php', array(
            'articles' => $articles
        ));        
    }
}
