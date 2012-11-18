<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\ArticleLocalization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller {
    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $repository->setLanguage($this->getRequest()->getLocale());
        $recentArticles = $repository->findOrderedByCreated(10);
        $popularArticles = $repository->findOrderedByPoint(10);
        return $this->render('PuluPalstaBundle:Front:index.html.php', array(
            'recentArticles' => $recentArticles,
            'popularArticles' => $popularArticles
        ));
    }
}