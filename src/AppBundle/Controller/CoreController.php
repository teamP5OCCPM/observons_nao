<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Form\ObservationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $observations = $em->getRepository('AppBundle:Observation')->getIndexObservations(4, "validate");
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
     * @param $page
     *
     * @return Response
     * @Route("/les-observations/{page}", name="observations")
     */
    public function observationsAction($page) : Response
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " .$page. " n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();

        $nbPerPage = 12;
        $listObservations = $em->getRepository('AppBundle:Observation')->getObservations($page, $nbPerPage, "validate");

        $nbPages = ceil(count($listObservations) / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " .$page. " n'existe pas.");
        }

        return $this->render('core/observations.html.twig', ['observations' => $listObservations, 'nbPages' => $nbPages, 'page' => $page]);
    }

    /**
     * @param Request      $request     *
     * @return Response
     * @Route("/ajouter-observation", name="addObservation")
     */
    public function addObservationAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $observation = new Observation();
        $form = $this->createForm(ObservationType::class, $observation);
        $form->handleRequest($request);

        $image = "default.jpg";
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $observation->setUser($user);
            $em->persist($observation);
            $em->flush();

            $this->addFlash('success', "L'observation est bien enregistrée et sera soumise à validation");

            return $this->redirectToRoute('homepage');
        }

        return $this->render('core/addObservation.html.twig', ['title' => "Ajouter une observation", 'form_observation' => $form->createView(), 'image' => $image]);
    }

    /**
     * @param Request $request
     * @param         $slug
     *
     * @return Response
     * @Route("/editer-observation/{slug}", name="editObservation")
     */
    public function editObservationAction(Request $request, $slug) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $observation = $em->getRepository('AppBundle:Observation')->findOneBySlug($slug);
        $form = $this->createForm(ObservationType::class, $observation);
        $form->handleRequest($request);

        $image = $observation->getImageName();

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', "L'observation à bien été modifié");

            return $this->redirectToRoute('manageObservations', ['status'  => 'tous']);
        }

        return $this->render('core/addObservation.html.twig', ['title' => "Editer une observation", 'form_observation' => $form->createView(), 'image' => $image]);
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

  

    /**
     * @param $page
     * 
     * @return Response
     * @Route("/resultats/{page}", name="results")
     */
    public function resultsAction($page) : Response
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " .$page. " n'existe pas.");
        }

        $em = $this->getDoctrine()->getManager();

        $nbPerPage = 12;
        $listObservations = $em->getRepository('AppBundle:Observation')->getObservations($page, $nbPerPage, "validate");
        $nbOfResults = count($listObservations);

        $nbPages = ceil($nbOfResults / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " .$page. " n'existe pas.");
        }

        return $this->render('core/results.html.twig', [
            'observations' => $listObservations, 
            'nbPages' => $nbPages, 
            'page' => $page,
            
            ]);        
    }

    /**
     *  @param Request $request
     * 
     * @return JsonResponse
     * @Route("/resultsJson", name="resultsJson")
     */
    public function searchAction(Request $request) 
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AppBundle:Observation')
        ;

        $listMarkers = $repository->findMarkers();
    
        return new JsonResponse($listMarkers);
    }

     /**
     *  @param Request $request
     * 
     * @return JsonResponse
     * @Route("/birds.json", name="birdsJson")
     */
    public function findBirdsAction(Request $request) : JsonResponse
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AppBundle:Bird')
        ;

        $listBirds = $repository->findArray();
    
        return new JsonResponse($listBirds);
    }

     /**
     *  @param Request $request
     * 
     * @return JsonResponse
     * @Route("/locations.json", name="locationsJson")
     */
    public function findLocationsAction(Request $request) : JsonResponse
    {
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('AppBundle:Observation')
        ;

        $listLocations = $repository->findAllLocations();
    
        return new JsonResponse($listLocations);
    }
}

