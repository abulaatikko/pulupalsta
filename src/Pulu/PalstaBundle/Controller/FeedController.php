<?php
namespace Pulu\PalstaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FeedController extends Controller {

    public function recentArticlesAction(Request $R) {
        $locale = $R->getLocale();
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $repository->setLanguage($locale);
        $recentArticles = $repository->findOrderedByPublishedForPublic(10);        

        return $this->render('PuluPalstaBundle:Feed:recentArticles.xml.php', array(
            'recentArticles' => $recentArticles,
            'locale' => $locale
        ));
    }

    public function recentCommentsAction(Request $R) {
        $locale = $R->getLocale();
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Comment');
        $recentComments = $repository->findByCreated(10, null, $locale);        

        return $this->render('PuluPalstaBundle:Feed:recentComments.xml.php', array(
            'recentComments' => $recentComments,
            'locale' => $locale
        ));
    }

}
