<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\Comment;
use Pulu\PalstaBundle\Entity\Visit;
use Pulu\PalstaBundle\Entity\Rating;
use Pulu\PalstaBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller {

    public function viewAction(Request $R, $article_number, $name) {
        $securityContext = $this->container->get('security.context');
        $is_admin = $securityContext->isGranted('ROLE_ADMIN');
        $is_friend = $securityContext->isGranted('ROLE_FRIEND');

        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findOneBy(array('article_number' => $article_number, 'deleted' => null));

        switch ($article->getAccess()) {
            case Article::ACCESS_ALL:
                break;
            case Article::ACCESS_FRIEND:
                if (! $is_friend && ! $is_admin) {
                    $article = null;
                }
                break;
            case Article::ACCESS_ADMIN:
                if (! $is_admin) {
                    $article = null;
                }
                break;
            default:
                $article = null;
                break;
        }
        if (! $article instanceof Article) {
            throw $this->createNotFoundException();
        }

        $comments = $this->getDoctrine()->getRepository('PuluPalstaBundle:Comment')->findByCreated(null, $article->getId(), $R->getLocale(), 'ASC');;

        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment);

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
            'rating' => $rating,
            'doctrine' => $this->getDoctrine(),
            'router' => $this->get('router')
        ));
    }

    public function redirectAction(Request $R, $article_number) {
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findOneBy(array('article_number' => $article_number));
        if (! $article instanceof Article) {
            throw $this->createNotFoundException();
        }
        $name = $article->getName($R->getLocale());
        $name = $this->get('helper')->toFilename($name);

        return $this->redirect($this->generateUrl('pulu_palsta_article', array('article_number' => $article_number, 'name' => $name)), 301);
    }

}
