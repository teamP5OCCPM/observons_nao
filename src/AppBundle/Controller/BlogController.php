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
     *
     * @return Response
     * @Route("/article/{slug}", name="showArticle")
     */
    public function showArticleAction($slug) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findOneBySlug($slug);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);



        return $this->render('blog/showArticle.html.twig', ['article' => $article, 'form' => $form->createView()]);
    }
}
