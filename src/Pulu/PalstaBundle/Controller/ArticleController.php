<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\Comment;
use Pulu\PalstaBundle\Entity\Visit;
use Pulu\PalstaBundle\Entity\Rating;
use Pulu\PalstaBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller {

    public function viewAction($id, $name) {
        $R = $this->get('request');
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findOneBy(array('id' => $id, 'is_public' => true, 'deleted' => null));
        if (! $article instanceof Article) {
            throw $this->createNotFoundException();
        }
        $comments = $this->getDoctrine()->getRepository('PuluPalstaBundle:Comment')->findByCreated(null, $article->getId(), $R->getLocale(), 'ASC');;

        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment);

        if ($R->isMethod('POST')) {
            $failed = true;
            $errorMessage = '';
            $translator = $this->get('translator');
            $requestData = $R->request->get('comment');
            if (isset($requestData['safety_question'])) {
                $answers = unserialize(base64_decode($requestData['safety_answer']));
                array_map('mb_strtolower', $answers);
                if (in_array(mb_strtolower($requestData['safety_question']), $answers)) {
                    if (isset($requestData['author_name']) && mb_strlen($requestData['author_name']) < 64) {
                        $form->bind($R);
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($comment);
                        if ($form->isValid()) {
                            $comment->setBody(strip_tags($comment->getBody()));
                            $comment->setArticle($article);
                            $comment->setLanguage($R->getLocale());
                            $comment->setAuthorIpAddress($R->getClientIp());
                            $comment->setAuthorUserAgent($R->server->get('HTTP_USER_AGENT'));

                            $em->flush();
                            $this->get('session')->getFlashBag()->add('notice', $translator->trans('Kommentti lähetettiin onnistuneesti'));
                            $failed = false;
                        }
                    } else {
                        $errorMessage = 'Nimesi on liian pitkä';
                    }
                }
            }
            if ($failed) {
                $form = $this->createForm(new CommentType(), $comment, array(
                    'default_body' => $requestData['body'],
                    'default_author_name' => $requestData['author_name']
                ));
                if (empty($errorMessage)) {
                    $errorMessage = 'Kommentin lähetys epäonnistui';
                }
                $this->get('session')->getFlashBag()->add('error', $translator->trans($errorMessage));
            } else {
                return $this->redirect($this->generateUrl('pulu_palsta_article', array('id' => $article->getId())));
            }
        }

        // Register visit
        $ip_address = $R->getClientIp();
        $user_agent = $R->server->get('HTTP_USER_AGENT');
        $author_hash = md5($ip_address . $user_agent);
        $isRegistered = $this->getDoctrine()->getRepository('PuluPalstaBundle:Visit')->isRegistered($article->getId(), $author_hash);
        if (! $isRegistered) {
            $em = $this->getDoctrine()->getManager();
            $visit = new Visit();
            $visit->setArticle($article);
            $visit->setAuthorIpAddress($ip_address);
            $visit->setAuthorUserAgent($user_agent);
            $visit->setAuthorHash($author_hash);
            $em->persist($visit);
            $em->flush();
        }

        $articleKeywords = $this->getDoctrine()->getRepository('PuluPalstaBundle:Keyword')->findByArticleOrderedByWeight($article);

        // Find rating by current user
        $rating = 0;
        $ratingEntity = $this->getDoctrine()->getRepository('PuluPalstaBundle:Rating')->findOneBy(array('article' => $article->getId(), 'author_hash' => $author_hash));
        if ($ratingEntity instanceof Rating) {
            $rating = $ratingEntity->getRating();
        }

        return $this->render('PuluPalstaBundle:Article:view.html.php', array(
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView(),
            'article_keywords' => $articleKeywords,
            'rating' => $rating
        ));
    }

    public function redirectAction($id) {
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findOneBy(array('id' => $id, 'is_public' => true, 'deleted' => null));
        if (! $article instanceof Article) {
            throw $this->createNotFoundException();
        }
        $name = $article->getName($this->getRequest()->getLocale());
        $name = $this->get('helper')->toFilename($name);

        return $this->redirect($this->generateUrl('pulu_palsta_article', array('id' => $id, 'name' => $name)), 301);
    }


}
