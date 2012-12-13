<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller {

    public function articleRatingAction() {
        $R = $this->get('request');

        $success = false;
        if ($R->isMethod('POST')) {
            $article_id = $R->get('article_id');
            $rating = $R->get('rating');
            $ip_address = $R->getClientIp();
            $user_agent = $R->server->get('HTTP_USER_AGENT');
            //file_put_contents('/tmp/log', var_export(array($article_id, $rating)), FILE_APPEND);
            $author_hash = md5($ip_address . $user_agent);

            $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->find(array('id' => $article_id, 'is_public' => true, 'deleted' => null));

            if ($article instanceof Article) {
                $ratingEntity = $this->getDoctrine()->getRepository('PuluPalstaBundle:Rating')->findOneBy(array('article' => $article->getId(), 'author_hash' => $author_hash));
                if (! $ratingEntity instanceof Rating) {
                    $ratingEntity = new Rating();
                }
                $ratingEntity->setArticle($article);
                $ratingEntity->setAuthorIpAddress($ip_address);
                $ratingEntity->setAuthorUserAgent($user_agent);
                $ratingEntity->setAuthorHash($author_hash);
                $ratingEntity->setRating($rating);
                $em = $this->getDoctrine()->getManager();
                $em->persist($ratingEntity);
                $em->flush();
                $success = true;
            }            
        }

        $response = new Response(json_encode(array('success' => $success)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}