<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminController
 *
 * @package         AppBundle\Controller
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="board")
     */
    public function boardAction()
    {
        return $this->render('admin/board.html.twig');
    }

    /**
     * @Route("/mes-observations", name="myObservations")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myObservationsAction() : Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $observationsList = $em->getRepository('AppBundle:Observation')->findByUser($user);

        return $this->render('admin/myObservations.html.twig', ['observations' =>$observationsList]);
    }

    /**
     * @Route("/gestion-observations/{status}", name="manageObservations")
     * @param $status
     *
     * @return Response
     */
    public function manageObservationsAction($status)
    {
        $em = $this->getDoctrine()->getManager();

        switch ($status) {
            case "validate":
                $observations = $em->getRepository('AppBundle:Observation')->findByStatus($status);
                return $this->render('admin/manageObservations.html.twig', ['observations' => $observations]);
                        break;
            case "waiting":
                $observations = $em->getRepository('AppBundle:Observation')->findByStatus($status);
                return $this->render('admin/manageObservations.html.twig', ['observations' => $observations]);
                        break;
            case "refused":
                $observations = $em->getRepository('AppBundle:Observation')->findByStatus($status);
                return $this->render('admin/manageObservations.html.twig', ['observations' => $observations]);
                        break;
        }
        $observations = $em->getRepository('AppBundle:Observation')->findAll();
        return $this->render('admin/manageObservations.html.twig', ['observations' => $observations]);
    }

    /**
     * @param $slug
     *
     * @return RedirectResponse
     * @Route("/validate-observation/{slug}", name="validateObservation")
     */
    public function validateObservationAction($slug) : RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $observation = $em->getRepository('AppBundle:Observation')->findOneBySlug($slug);
        $observation->setStatus("validate");

        $em->flush();

        $this->addFlash('warning', "L'observation, " . $observation->getTitle() . " a bien été validé");

        return $this->redirectToRoute('manageObservations', ['status' => "tous"]);
    }

    /**
     * @param $slug
     *
     * @return RedirectResponse
     * @Route("/waiting-observation/{slug}", name="waitingObservation")
     */
    public function waitingObservationAction($slug) : RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $observation = $em->getRepository('AppBundle:Observation')->findOneBySlug($slug);
        $observation->setStatus("waiting");

        $em->flush();

        $this->addFlash('warning', "L'observation, " . $observation->getTitle() . " a bien été mis en attente");

        return $this->redirectToRoute('manageObservations', ['status' => "tous"]);
    }

    /**
     * @param $slug
     *
     * @return RedirectResponse
     * @Route("/refused-observation/{slug}", name="refusedObservation")
     */
    public function refusedObservationAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $observation = $em->getRepository('AppBundle:Observation')->findOneBySlug($slug);
        $observation->setStatus("refused");

        $em->flush();

        $this->addFlash('warning', "L'observation a bien été refusé et ne sera pas visible sur le site");

        return $this->redirectToRoute('manageObservations', ['status' => "tous"]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/ajouter-article", name="addArticle")
     */
    public function addArticleAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        $image = "adefault.jpg";

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUser($user);
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', "L'article est bien enregistrée et sera soumis à validation");

            return $this->redirectToRoute('addArticle');
        }

        return $this->render('admin/addArticle.html.twig', ['title' => "Ajouter un article", 'form_article' => $form->createView(), 'image' => $image]);
    }

    /**
     * @Route("/gestion-articles/{status}", name="manageArticles")
     */
    public function manageArticlesAction($status)
    {
        $em = $this->getDoctrine()->getManager();

        switch ($status) {
            case "tous":
                $articles = $em->getRepository('AppBundle:Article')->findAll();
                return $this->render('admin/manageArticles.html.twig', ['articles' => $articles ]);
                        break;

            case "isPublished":
                $articles = $em->getRepository('AppBundle:Article')->findByIsPublished(1);
                return $this->render('admin/manageArticles.html.twig', ['articles' => $articles]);
                        break;

            case "waitting":
                $articles = $em->getRepository('AppBundle:Article')->findByIsPublished(0);
                return $this->render('admin/manageArticles.html.twig', ['articles' => $articles]);
                        break;
        }

        $articles = $em->getRepository('AppBundle:Article')->findAll();

        return $this->render('admin/manageArticles.html.twig', ['articles' => $articles]);
    }


    /**
     * @param $slug
     *
     * @return RedirectResponse
     * @Route("/waiting-article/{slug}", name="waitingArticle")
     */
    public function waitingArticleAction($slug) : RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findOneBySlug($slug);
        $article->setIsPublished(false);

        $em->flush();

        $this->addFlash('warning', "L'article, " . $article->getTitle() . " a bien été mis en attente");

        return $this->redirectToRoute('manageArticles', ['status' => "tous"]);
    }


    /**
     * @param $slug
     *
     * @return RedirectResponse
     * @Route("/validate-article/{slug}", name="validateArticle")
     */
    public function validateArticleAction($slug) : RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findOneBySlug($slug);
        $article->setIsPublished(true);

        $em->flush();

        $this->addFlash('warning', "L'article, " . $article->getTitle() . " a bien été publié");

        return $this->redirectToRoute('manageArticles', ['status' => "tous"]);
    }

    /**
     * @param Request $request
     * @param         $slug
     *
     * @return Response
     * @Route("/editer-article/{slug}", name="editArticle")
     */
    public function editArticleAction(Request $request, $slug) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findOneBySlug($slug);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        $image = $article->getImageName();

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', "L'article à bien été modifié");

            return $this->redirectToRoute('manageArticles', ['status'  => 'tous']);
        }

        return $this->render('admin/addArticle.html.twig', ['title' => "Editer un article", 'form_article' => $form->createView(), 'image' => $image]);
    }

    /**
     * @param $slug
     *
     * @return RedirectResponse
     * @Route("/refused-article/{slug}", name="refusedArticle")
     */
    public function refusedArticleAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:article')->findOneBySlug($slug);

        $em->remove($article);

        $em->flush();

        $this->addFlash('warning', "L'article a bien été supprimé.");

        return $this->redirectToRoute('manageArticles', ['status' => "tous"]);
    }

    /**
     * @Route("/gestion-commentaires/{status}", name="manageComs")
     * @param $status
     *
     * @return Response
     */
    public function manageComsAction($status)
    {

        $em = $this->getDoctrine()->getManager();

        switch ($status) {
            case "isReported":
                $comments = $em->getRepository('AppBundle:Comment')->findByIsReported(1);
                return $this->render('admin/manageComs.html.twig', ['comments' => $comments]);
                    break;
            case "isHidden":
                $comments = $em->getRepository('AppBundle:Comment')->findByIsHidden(1);
                return $this->render('admin/manageComs.html.twig', ['comments' => $comments]);
                    break;
            default:
                $comments = $em->getRepository('AppBundle:Comment')->findAll();
                return $this->render('admin/manageComs.html.twig', ['comments' => $comments]);
        }
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     * @Route("/hidden-comment/{id}", name="hiddenComment")
     */
    public function hiddenCommentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('AppBundle:Comment')->findOneById($id);

        $comment->setIsHidden(true);

        $em->persist($comment);

        $em->flush();

        $this->addFlash('warning', "Le commentaire est masqué.");

        return $this->redirectToRoute('manageComs', ['status' => "tous"]);
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     * @Route("/validate-comment/{id}", name="validateComment")
     */
    public function validateCommentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('AppBundle:Comment')->findOneById($id);

        $comment->setIsReported(false);

        $em->persist($comment);

        $em->flush();

        $this->addFlash('warning', "Le commentaire a été validé.");

        return $this->redirectToRoute('manageComs', ['status' => "tous"]);
    }

    /**
     * @param $id
     *
     * @return RedirectResponse
     * @Route("/noHidden-comment/{id}", name="noHiddenComment")
     */
    public function noHiddenCommentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('AppBundle:Comment')->findOneById($id);

        $comment->setIsHidden(false);

        $em->persist($comment);

        $em->flush();

        $this->addFlash('warning', "Le commentaire a été démasqué.");

        return $this->redirectToRoute('manageComs', ['status' => "tous"]);
    }



    /**
     * @Route("/mise-a-jour-bdd", name="manageBdd")
     */
    public function manageBddAction()
    {
        return $this->render('admin/manageBdd.html.twig');
    }

    /**
     * @Route("/gestion-comptes", name="manageAccounts")
     */
    public function manageAccountsAction()
    {
        return $this->render('admin/manageAccounts.html.twig');
    }
}
