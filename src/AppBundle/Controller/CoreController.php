<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $observations = $em->getRepository('AppBundle:Observation')->findAll();
        $articles = $em->getRepository('AppBundle:Article')->findAll();

        return $this->render('core/index.html.twig', ['observations' => $observations, 'articles' => $articles]);
    }

    /**
     * @param $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/observation/{slug}", name="showObservation")
     */
    public function showObservationAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $observation = $em->getRepository('AppBundle:Observation')->findOneBySlug($slug);

        return $this->render('core/showObservation.html.twig', ['observation' => $observation]);
    }

    /**
     * @Route("/les-observations", name="observations")
     */
    public function observationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $observations = $em->getRepository('AppBundle:Observation')->findAll();

        return $this->render('core/observations.html.twig', ['observations' => $observations]);
    }

    /**
     * @Route("/ajouter-observation", name="addObservation")
     */
    public function addObservationAction(Request $request)
    {
        return $this->render('core/addObservation.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        return $this->render('core/contact.html.twig');
    }

    /**
     * @Route("/qui-sommes-nous", name="who")
     */
    public function whoAction(Request $request)
    {
        return $this->render('core/who.html.twig');
    }

    /**
     * @Route("/pourquoi-ce-site", name="why")
     */
    public function whyAction(Request $request)
    {
        return $this->render('core/why.html.twig');
    }
}
