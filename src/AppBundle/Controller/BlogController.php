<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Comment;
use AppBundle\Form\ArticleType;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @param $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/blog/{page}", name="articles", requirements={"page": "\d+"})
     */
    public function articlesAction($page) : Response
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " .$page. " n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();

        $nbPerPage = 12;
        $listArticles = $em->getRepository('AppBundle:Article')->getArticles($page, $nbPerPage);

        $nbPages = ceil(count($listArticles) / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " .$page. " n'existe pas.");
        }

        return $this->render('blog/articles.html.twig', ['articles' => $listArticles, 'nbPages' => $nbPages, 'page' => $page]);
    }

    /**
     * @param $slug
     * @param $request
     * @return Response
     * @Route("/article/{slug}", name="showArticle")
     */
    public function showArticleAction($slug, Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findOneBySlug($slug);

        $parentComments = $article->getComments()->filter(
            function ($entry) {
                return in_array($entry->getParent(), [null]);
            }
        );

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parentId = $form->getData()->getParentId();
            $commentParent = $em->getRepository('AppBundle:Comment')->findOneById($parentId);
            $comment->setParent($commentParent);
            $comment->setArticle($article);

            $validator = $this->get('validator');
            $errors = $validator->validate($comment);

            if (count($errors) > 0) {
                return new Response((string) $errors);
            } else {
                $em->persist($comment);
                $em->flush();

                $this->addFlash('success', "Le commentaire a été ajouté avec succès !!!");

                return $this->redirectToRoute('showArticle', ['slug' => $slug]);
            }
        }
        return $this->render('blog/showArticle.html.twig', ['article' => $article, 'parentComments' => $parentComments ,'form' => $form->createView()]);
    }

    /**
     * @param $id
     * @return Response
     * @Route("/reported-comment/{slug}/{id}", name="reportedComment")
     */
    public function reportedCommentAction($slug, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findOneBySlug($slug);
        $comment = $em->getRepository('AppBundle:Comment')->findOneById($id);
        $comment->setIsReported(true);

        $validator = $this->get('validator');
        $errors = $validator->validate($comment);

        if (count($errors) > 0) {
            return new Response((string) $errors);
        } else {
            $em->persist($comment);
            $em->flush();


            // envoi d'un mail pour indiquer aux editors qu'un commentaire a été signalé
            // Récupération du service d'envoi de mail
            $mailer = $this->container->get('send_mail');

            $objet = [
                'articleSlug' => $article->getSlug(),
                'articleTitle' => $article->getTitle(),
                'commentAuthor' => $comment->getAuthor(),
            ];


            $editors = $em->getRepository('AppBundle:User')->getUserEditor();

            foreach ($editors as $editor) {
                $mailer->sendMessage(
                    $editor->getEmail(),
                    'Commentaire signalé',
                    'mail/comment-reported-model.html.twig',
                    'teamp5.oc.cpm@gmail.com',
                    $objet
                );
            }

            $this->addFlash('warning', "Le commentaire a été signalé.");

            return $this->redirectToRoute('showArticle', ['slug' => $slug]);
        }
    }
}
