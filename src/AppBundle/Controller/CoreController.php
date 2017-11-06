<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Observation;
use AppBundle\Form\ContactType;
use AppBundle\Form\ObservationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $observations = $em->getRepository('AppBundle:Observation')->getIndexObservations(4, "validate");
        $articles = $em->getRepository('AppBundle:Article')->getIndexArticles(4);
        $searchForm = $this->createForm('AppBundle\Form\SearchType');
        $searchForm->handleRequest($request);

        if ($searchForm->isValid() && $searchForm->isSubmitted()) {
            return $this->redirectToRoute('results');
        }

        return $this->render('core/index.html.twig', ['observations' => $observations, 'articles' => $articles, 'searchForm' => $searchForm->createView()]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function searchFieldAction(Request $request) : Response
    {
        $searchForm = $this->createForm('AppBundle\Form\SearchType');
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            return $this->redirectToRoute('results');
        }

        return $this->render(':inc:searchField.html.twig', ['searchForm' => $searchForm->createView()]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function searchFieldMobileAction(Request $request) : Response
    {
        $searchForm = $this->createForm('AppBundle\Form\SearchType');
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            return $this->redirectToRoute('results');
        }

        return $this->render(':inc:searchFieldMobile.html.twig', ['searchForm' => $searchForm->createView()]);
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
        $id = $observation->getId();
        $species = $observation->getBird()->getSpecies();
        $sameSpecies = $em->getRepository('AppBundle:Observation')->getSameSpecies($species, 4, $id);
        $otherImgSpecies = $em->getRepository('AppBundle:Observation')->getOtherImgSpecies($species, $id);

        return $this->render('core/showObservation.html.twig', ['observation' => $observation, 'sameSpecies' => $sameSpecies, 'otherImgSpecies' => $otherImgSpecies]);
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
     * @param Request $request *
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
            if ($form->getData()->getImageName() === null) {
                $observation->setImageName($image);
            }
            $observation->setUser($user);
            $validator = $this->get('validator');
            $errors = $validator->validate($observation);
            if (count($errors) > 0)
            {
                return new Response( (string) $errors);
            }else {
                $em->persist($observation);
                $em->flush();

                $this->addFlash('success', "L'observation est bien enregistrée et sera soumise à validation");

                return $this->redirectToRoute('homepage');
            }
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
        $form = $this->createForm(ContactType::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('core/contact.html.twig', ['form' => $form->createView()]);
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
     * @param Request $request
     * @param         $page
     *
     * @return Response
     * @Route("/resultats/{page}", name="results")
     */
    public function resultsAction(Request $request, $page) : Response
    {
        $filter = $request->request->get('search')['filter'];
        $keyword = $request->request->get('search')['search'];
        $em = $this->getDoctrine()->getManager();
        switch($filter) {
            case("place"):
                $resultList = $em->getRepository('AppBundle:Observation')->findBy(['city' => $keyword],['status' => 'validate'], ['createdAt' => 'DESC']);
                break;

            case("species"):
                $resultList = $em->getRepository('AppBundle:Observation')->findBySpecies('validate', $keyword);
                break;

            case("name"):
                $resultList = $em->getRepository('AppBundle:Observation')->findKeyword('validate', $keyword);
                break;
        }

        if ($page < 1) {
            throw $this->createNotFoundException("La page " .$page. " n'existe pas.");
        }

        $nbPerPage = 12;
        $nbOfResults = count($resultList);

        $nbPages = ceil($nbOfResults / $nbPerPage);

        if ($nbPages == 0) {
            $this->addFlash('warning', 'Aucun résultats n\'a pu être trouvés avec le mot "'. $keyword .'"');
            $this->redirectToRoute('results', ['page' => 1]);
        } else {
            if ($page > $nbPages) {
                throw $this->createNotFoundException("La page " .$page. " n'existe pas.");
            }
        }

        return $this->render('core/results.html.twig', ['observations' => $resultList, 'nbPages' => $nbPages, 'page' => $page, 'title' => 'Résultats de votre recherche']);
    }

     /**
      * @param Request $request
      *
      * @return JsonResponse
      * @Route("birds.json", name="birdsJson")
      */
    public function findBirdsAction(Request $request) : JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observation');
            $listBirds = $repository->findAllBirds('validate');

            return new JsonResponse($listBirds);
        }

    }

     /**
      * @param Request $request
      *
      * @return JsonResponse
      * @Route("locations.json", name="locationsJson")
      */
    public function findLocationsAction(Request $request) : JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observation');
            $listLocations = $repository->findAllLocations('validate');

            return new JsonResponse($listLocations);
        }

    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @Route("titles.json", name="titlesJson")
     */
    public function findTitlesAction(Request $request) : JsonResponse
    {
        if ($request->isXmlHttpRequest()) {
            $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Observation');
            $listTitles = $repository->findAllTitles('validate');

            return new JsonResponse($listTitles);
        }

    }

    /**
     * @param Request $request
     * @param         $status
     * @param         $role
     *
     * @return JsonResponse
     * @Route("notifs_obs/{status}/{role}", name="notifsObs")
     */
    public function notifsObsAction(Request $request, $status, $role)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();

            $nbObs = [];
            if ($role == "naturalist") {
                $nbObs = $em->getRepository('AppBundle:Observation')->findByStatus($status);
            }

            if ($role == "editor") {
                $nbObs = $em->getRepository('AppBundle:Comment')->findByIsReported($status);
            }

            $count = count($nbObs);

            if($nbObs)
            {
                return new JsonResponse(array('message' => $count, 200));
            }
        }
        return new JsonResponse(array('message' => false, 400));
    }
}
