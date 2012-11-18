<?php
namespace Pulu\PalstaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListController extends Controller {
    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $repository->setLanguage($this->getRequest()->getLocale());
        $articles = $repository->findAllOrderedByName();
        return $this->render('PuluPalstaBundle:List:index.html.php', array(
            'articles' => $articles
        ));        
    }
}
