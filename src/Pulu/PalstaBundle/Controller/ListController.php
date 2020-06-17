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
            'articles' => $articles,
            'articleTypes' => [
                Article::TYPE_UNDEFINED => '',
                Article::TYPE_TRAVEL => 'Travel',
                Article::TYPE_RESEARCH => 'Research',
                Article::TYPE_ART => 'Art',
                Article::TYPE_OPINION => 'Opinion',
                Article::TYPE_SPORT => 'Sport',
                Article::TYPE_NUTRITION => 'Nutrition'
            ]
        ));        
    }
}
