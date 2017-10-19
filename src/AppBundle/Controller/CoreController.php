<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    /**
     * @return Response
     * @Route("/", name="homepage")
     */
    public function indexAction() : Response
    {
        $em = $this->getDoctrine()->getManager();
        $observations = $em->getRepository('AppBundle:Observation')->getIndexObservations(4);
        $articles = $em->getRepository('AppBundle:Article')->getIndexArticles(4);

        return $this->render('core/index.html.twig', ['observations' => $observations, 'articles' => $articles]);
    }

    /**
     * @param $slug
     *
     * @return Response
     * @Route("/observation/{slug}", name="showObservation")
     */
    public function showObservationAction($slug) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $observation = $em->getRepository('AppBundle:Observation')->findOneBySlug($slug);

        return $this->render('core/showObservation.html.twig', ['observation' => $observation]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/les-observations", name="observations")
     */
    public function observationsAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $observations = $em->getRepository('AppBundle:Observation')->findAll();

        return $this->render('core/observations.html.twig', ['observations' => $observations]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/ajouter-observation", name="addObservation")
     */
    public function addObservationAction(Request $request) : Response
    {
        return $this->render('core/addObservation.html.twig');
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request) : Response
    {
        return $this->render('core/contact.html.twig');
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/qui-sommes-nous", name="who")
     */
    public function whoAction(Request $request) : Response
    {
        return $this->render('core/who.html.twig');
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/pourquoi-ce-site", name="why")
     */
    public function whyAction(Request $request) : Response
    {
        return $this->render('core/why.html.twig');
    }
}
