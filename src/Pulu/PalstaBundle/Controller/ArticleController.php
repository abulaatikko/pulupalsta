<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\ArticleLocalization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller {

    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $articles = $repository->findAll();
        $html = '<ul>';
        foreach ($articles as $article) {
            $html .= '<li>' . $article->getName('FI') . ' (' . $article->getId() . ', ' . $article->getTeaser('FI') . ')</li>';
        }
        $html .= '</ul>';
        
        return new Response($html);
    }
}
