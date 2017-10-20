<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * @param $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/blog/{page}", name="articles")
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
     * @return Response
     *
     * @Route("/blog/ajouter-article", name="addArticle")
     */
    public function addArticleAction()
    {
        return $this->render('blog/addArticle.html.twig');
    }
}
