<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\Comment;
use Pulu\PalstaBundle\Entity\Rating;
use Pulu\PalstaBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Parsedown;

class AjaxController extends Controller {

    public function articleRatingAction(Request $R) {
        $translator = $this->get('translator');

        $message = $translator->trans('Arviointi epäonnistui');
        $success = false;
        if ($R->isMethod('POST')) {
            $article_id = $R->get('article_id');
            $rating = $R->get('rating');
            $ip_address = $R->getClientIp();
            $user_agent = $R->server->get('HTTP_USER_AGENT');
            $author_hash = md5($ip_address . $user_agent);

            $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->find(array('id' => $article_id));
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
                $message = $translator->transChoice('{1}Arviointi onnistui: annoit %stars% tähden.|{0,2,3,4,5}Arviointi onnistui: annoit %stars% tähteä.', $rating, array('%stars%' => $rating));
                $message .= ' ' . $translator->trans('Voit vaihtaa antamaasi arvosanaa.');
            }            
        }

        $response = new Response(json_encode(array('success' => $success, 'message' => $message)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function articleCommentAction(Request $R) {
        $translator = $this->get('translator');

        $success = false;
        $message = $translator->trans('Commenting failure');

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $Parsedown = new Parsedown();

        if ($R->isMethod('POST')) {
            $keyCheckDelay = 5 * 1000000; // seconds
            usleep($keyCheckDelay);
            $article_id = $R->get('article_id');
            $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->find(array('id' => $article_id));

            if ($article instanceof Article) {
                $requestData = $R->request->get('comment');

                if (isset($requestData['safety_question'])) {
                    $answers = unserialize(base64_decode($requestData['safety_answer']));
                    $answers = array_map('mb_strtolower', $answers);

                    if (in_array(mb_strtolower($requestData['safety_question']), $answers)) {
                        if (isset($requestData['author_name']) && mb_strlen($requestData['author_name']) < 64) {
                            $ip_address = $R->getClientIp();
                            $user_agent = $R->server->get('HTTP_USER_AGENT');

                            $tooFast = $this->getDoctrine()->getRepository('PuluPalstaBundle:Comment')->tooFast($article->getId(), $ip_address, $user_agent, '60 secs');

                            if (! $tooFast) {
                                $key = $requestData['author_key'] ? hash('sha256', $requestData['author_key'] . $this->container->getParameter('salt.author_key')) : '';

                                if (empty($requestData['author_key']) && $this->getDoctrine()->getRepository('PuluPalstaBundle:Comment')->isAuthorNameReserved($requestData['author_name'])) {
                                    $message = $translator->trans('Alias is already protected');
                                } else if (! $this->getDoctrine()->getRepository('PuluPalstaBundle:Comment')->isAuthorSecured($requestData['author_name'], $key)) {
                                    usleep($keyCheckDelay);
                                    $message = $translator->trans('Key didn\'t work');
                                } else {
                                    $form->handleRequest($R);
                                    $em = $this->getDoctrine()->getManager();
                                    $em->persist($comment);
                                    if ($form->isValid()) {
                                        $comment->setBody(strip_tags($comment->getBody()));
                                        $comment->setArticle($article);
                                        $comment->setLanguage($R->getLocale());
                                        $comment->setAuthorIpAddress($R->getClientIp());
                                        $comment->setAuthorUserAgent($R->server->get('HTTP_USER_AGENT'));
                                        $comment->setAuthorKey($key);

                                        $em->flush();
                                        $success = true;
                                        $isProtected = ! empty($key);
                                        $message = $translator->trans('Commenting success');
                                    }
                                }
                            } else {
                                $message = 'Too fast commenting. Wait a few minutes.';
                            }
                        } else {
                            $message = $translator->trans('Too long alias');
                        }
                    }
                }
            }
        }
        $data = $success 
            ? array(
                'comment' => $Parsedown->text($comment->getBody()),
                'author_name' => $comment->getAuthorName(),
                'created' => $comment->getCreated()->format('Y-m-d H:i'),
                'is_protected' => ! empty($isProtected)
            ) : '';
        $response = new Response(json_encode(array('success' => $success, 'message' => $message, 'data' => $data)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function keywordAction(Request $R) {
        $translator = $this->get('translator');

        $success = false;
        $data = array();
        if ($R->isMethod('POST')) {
            $success = true;
            $keyword_id = $R->get('keyword_id');
            $locale = $R->get('locale');
            $keyword = $this->getDoctrine()->getRepository('PuluPalstaBundle:Keyword')->find($keyword_id);
            $articles = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findOrderedByVisitsForPublic(10, $keyword_id);
            foreach ($articles as $article) {
                $name = $article->getName($locale);
                $data[] = array(
                    'article_number' => $article->getArticleNumber(),
                    'name' => $name,
                    'visits' => $article->getVisits(),
                    'link_name' => $this->get('helper')->toFilename($name)
                );
            }
        }

        $response = new Response(json_encode(array('success' => $success, 'data' => $data)));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
