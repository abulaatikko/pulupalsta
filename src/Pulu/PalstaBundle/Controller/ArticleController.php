<?php
namespace Pulu\PalstaBundle\Controller;

use Pulu\PalstaBundle\Entity\Article;
use Pulu\PalstaBundle\Entity\Comment;
use Pulu\PalstaBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller {

    const SAFE_QUESTION_ANSWER = 'lima';

    public function viewAction($id, $name) {
        $R = $this->get('request');
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->find($id);
        $repository = $this->getDoctrine()->getRepository('PuluPalstaBundle:Comment');
        $comments = $repository->findByCreated(null, $article->getId(), $R->getLocale());

        $comment = new Comment();
        $form = $this->createForm(new CommentType(), $comment);

        if ($R->isMethod('POST')) {
            $translator = $this->get('translator');
            $data = $R->request->get('comment');
            if (isset($data['safe_question']) && mb_strtolower($data['safe_question']) == mb_strtolower(self::SAFE_QUESTION_ANSWER)) {
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
                    $this->get('session')->getFlashBag()->add('notice', $translator->trans('Kommentti on lähetetty'));
                } else {
                    $this->get('session')->getFlashBag()->add('error', $translator->trans('Kommentin lähetys epäonnistui'));
                }
            } else {
                $this->get('session')->getFlashBag()->add('error', $translator->trans('Kommentin lähetys epäonnistui'));
            }         

            return $this->redirect($this->generateUrl('pulu_palsta_article', array('id' => $article->getId())));
        }

        return $this->render('PuluPalstaBundle:Article:view.html.php', array(
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView()
        ));
    }

    public function redirectAction($id) {
        $article = $this->getDoctrine()->getRepository('PuluPalstaBundle:Article')->find($id);
        $name = $article->getName($this->getRequest()->getLocale());
        $name = $this->get('helper')->toFilename($name);

        return $this->redirect($this->generateUrl('pulu_palsta_article', array('id' => $id, 'name' => $name)), 301);
    }


}
