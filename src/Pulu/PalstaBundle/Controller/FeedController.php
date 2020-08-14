<?php
namespace Pulu\PalstaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FeedController extends Controller {

    public function articlesAction(Request $R) {
        $locale = $R->getLocale();
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $articles = $repository->findArticlesForFeed(30);

        return $this->render('PuluPalstaBundle:Feed:articles.xml.php', array(
            'articles' => $articles
        ));
    }

}
