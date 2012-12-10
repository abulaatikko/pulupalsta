<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\Comment;
use Pulu\PalstaBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller {

    public function viewAction($id, $name) {
        $R = $this->get('request');
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->findOneBy(array('id' => $id, 'is_public' => true, 'deleted' => null));
        if (! $article instanceof Article) {
            throw $this->createNotFoundException();
        }
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Comment');
        $comments = $repository->findByCreated(null, $article->getId(), $R->getLocale());

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

        $articleKeywords = $this->getDoctrine()->getRepository('PuluPalstaBundle:Keyword')->findByArticleOrderedByWeight($article);

        return $this->render('PuluPalstaBundle:Article:view.html.php', array(
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView(),
            'article_keywords' => $articleKeywords
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
