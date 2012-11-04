<?php
namespace Pulu\PalstaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListController extends Controller {
    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $articles = $repository->createQueryBuilder('A')->orderBy('A.created', 'DESC')->getQuery()->getResult();

        return $this->render('PuluPalstaBundle:List:index.html.php', array(
            'articles' => $articles
        ));

        
    }
}
