<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\VisitPerMonth;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Form;

class ApiController extends Controller {

    public function getVisitAction() {
        $articleRepository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article');
        $visitPerMonthRepository = $this->getDoctrine()->getRepository('PuluPalstaBundle:VisitPerMonth');

        $out = array();
        $articles = $articleRepository->findAll();
        foreach ($articles as $article) {
            if (! $article->isPublic()) {
                continue;
            }
            if (! $article->getAverageMonthlyVisits() < 50) {
                continue;
            }
            $visitPerMonthRepository->setArticle($article);
            $visitPerMonths = $visitPerMonthRepository->findVisitsPerMonth();

            $outVisits = array();
            foreach ($visitPerMonths as $visitPerMonth) {
                $outVisits[] = array(
                    'month' => $visitPerMonth['month'],
                    'visits' => $visitPerMonth['visits']
                );
            }
            
            $out[] = array(
                'article' => mb_strimwidth($article->getName(), 0, 32, '...') . ' (#' . $article->getArticleNumber() . ')',
                'visits' => $outVisits
            );
        }

        $response = new JsonResponse();
        $response->setData($out);
        return $response;
    }

}
