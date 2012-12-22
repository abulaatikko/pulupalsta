<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\ArticleLocalization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller {

    public function indexAction() {
        $keywordRepository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Keyword');
        $keywords = $keywordRepository->findAllOrderedByName();

        return $this->render('PuluPalstaBundle:Index:index.html.php', array(
            'keywords' => $keywords
        ));
    }

}