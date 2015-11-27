<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\ArticleLocalization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller {

    public function indexAction(Request $R) {
        $keywordRepository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Keyword');
        $keywordRepository->setLanguage($R->getLocale());
        $keywords = $keywordRepository->findAllOrderedByName();

        return $this->render('PuluPalstaBundle:Index:index.html.php', array(
            'keywords' => $keywords
        ));
    }

}