<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Form\ObservationType;
use AppBundle\Service\FileUploader;
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
        $listObservations = $em->getRepository('AppBundle:Observation')->getObservations($page, $nbPerPage);

        $nbPages = ceil(count($listObservations) / $nbPerPage);

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page " .$page. " n'existe pas.");
        }

        return $this->render('core/observations.html.twig', ['observations' => $listObservations, 'nbPages' => $nbPages, 'page' => $page]);
    }

    /**
     * @param Request      $request
     *
     * @param FileUploader $fileUploader
     *
     * @return Response
     * @Route("/ajouter-observation", name="addObservation")
     */
    public function addObservationAction(Request $request, FileUploader $fileUploader) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $observation = new Observation();
        $form = $this->createForm(ObservationType::class, $observation);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->getImage() !== null) {
                $image = $observation->getImage();
                $filename = $fileUploader->upload($image);
                $observation->setImage("img/observations/".$filename);
            } else {
                $observation->setImage("img/observations/default.jpg");
            }
            $observation->setUser($user);
            $em->persist($observation);
            $em->flush();

            $this->addFlash('success', "L'observation est bien enregistrée et sera soumise à validation");

            return $this->redirectToRoute('homepage');
        }

        return $this->render('core/addObservation.html.twig', ['form_observation' => $form->createView()]);
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
