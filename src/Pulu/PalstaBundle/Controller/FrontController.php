<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\ArticleLocalization;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller {

    public function indexAction() {
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $repository->setLanguage($this->getRequest()->getLocale());
        $recentArticles = $repository->findOrderedByCreatedForPublic(20);
        $visitedArticles = $repository->findOrderedByVisitsForPublic(20);
        $keywords = $this->getKeywords();       

        return $this->render('PuluPalstaBundle:Front:index.html.php', array(
            'recentArticles' => $recentArticles,
            'visitedArticles' => $visitedArticles,
            'keywords' => $keywords
        ));
    }

    protected function getKeywords() {
        $keywords = $this->getDoctrine()->getRepository('PuluPalstaBundle:Keyword')->findAllOrderedByName();
        // Find max weight
        $maxWeight = 1;
        foreach ($keywords as $keyword) {
            $weight = $keyword->getWeight();
            if ($weight > $maxWeight) {
                $maxWeight = $weight;
            }
        }

        $shuffledKeywords = array();
        foreach ($keywords as $keyword) {
            $weight = $keyword->getWeight();
            if ($weight > 0) {
                $normalized_weight = ceil(($weight / $maxWeight) * 6);
                $shuffledKeywords[] = array(
                    'name' => $keyword->getName($this->getRequest()->getLocale()),
                    'weight' => $weight,
                    'normalized_weight' => $normalized_weight,
                    'id' => $keyword->getId()
                );
            }
        }
        shuffle($shuffledKeywords);
        return array_slice($shuffledKeywords, 0, 100);
    }

}