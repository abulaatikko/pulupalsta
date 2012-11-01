<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\ArticleLocalization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller {
    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $recentArticles = $repository->createQueryBuilder('A')->orderBy('A.created', 'DESC')->setMaxResults(10)->getQuery()->getResult();
        $popularArticles = $repository->createQueryBuilder('A')->orderBy('A.points', 'DESC')->setMaxResults(10)->getQuery()->getResult();
        return $this->render('PuluPalstaBundle:Front:index.html.php', array(
            'recentArticles' => $recentArticles,
            'popularArticles' => $popularArticles
        ));
    }
}