<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('core/index.html.twig');
    }

    /**
     * @Route("/les-observations", name="observations")
     */
    public function observationsAction(Request $request)
    {
        return $this->render('core/observations.html.twig');
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
