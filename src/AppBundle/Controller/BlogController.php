<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="articles")
     */
    public function articlesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAll();

        return $this->render('blog/articles.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/blog/ajouter-article", name="addArticle")
     */
    public function addArticleAction(Request $request)
    {
        return $this->render('blog/addArticle.html.twig');
    }
}
