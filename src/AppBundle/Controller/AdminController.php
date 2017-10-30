<?php

namespace AppBundle\Controller;

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
     * @Route("/gestion-commentaires", name="manageComs")
     */
    public function manageComsAction()
    {
        return $this->render('admin/manageComs.html.twig');
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
