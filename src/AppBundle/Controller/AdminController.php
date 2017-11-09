<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Bird;
use AppBundle\Entity\Taxref;
use AppBundle\Form\ArticleType;
use AppBundle\Form\TaxrefType;
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
            case "tous":
                $observations = $em->getRepository('AppBundle:Observation')->findAll();
                return $this->render('admin/manageObservations.html.twig', ['observations' => $observations]);
                break;
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
            default:
                throw $this->createNotFoundException('Cette page n\'existe pas');
                break;
        }
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

        // On envoi un mail au proprietaire de l'observation pour lui indiquer que l'observation a été validé
        // Récupération du service d'envoi de mail
        $mailer = $this->container->get('send_mail');

        // Récupération du paramètre mail de destination "from"
        $from = $this->getParameter('mailer_user');

        $mailer->sendMessage($observation->getUser()->getEmail(), 'Validation de l\'observation', 'mail/validate-model.html.twig', $from, $observation);
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
            if ($form->getData()->getImageName() === null) {
                $article->setImageName($image);
            }
            $article->setUser($user);

            $validator = $this->get('validator');
            $errors = $validator->validate($article);
            if (count($errors) > 0) {
                return new Response((string) $errors);
            } else {
                $em->persist($article);
                $em->flush();

                if ($form->getData()->getIsPublished()) {
                    $this->addFlash('success', "L'article est bien publié");
                } else {
                    $this->addFlash('success', "L'article est bien enregistrée dans les brouillons");
                }

                return $this->redirectToRoute('addArticle');
            }
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
                $articles = $em->getRepository('AppBundle:Article')->findBy([], ['createdAt' => 'DESC']);
                return $this->render('admin/manageArticles.html.twig', ['articles' => $articles ]);
                break;

            case "isPublished":
                $articles = $em->getRepository('AppBundle:Article')->findBy(['isPublished' => true], ['createdAt' => 'DESC']);
                return $this->render('admin/manageArticles.html.twig', ['articles' => $articles]);
                break;

            case "waiting":
                $articles = $em->getRepository('AppBundle:Article')->findBy(['isPublished' => false], ['createdAt' => 'DESC']);
                return $this->render('admin/manageArticles.html.twig', ['articles' => $articles]);
                break;
            default:
                throw $this->createNotFoundException('Cette page n\'existe pas');
                break;
        }

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
                break;
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

        if ($comment->getIsReported() === true) {
            $comment->setIsReported(false);
        }

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
    public function manageBddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $fileBdd = $em->getRepository('AppBundle:Taxref')->getLast();

        $lastUpdate = $em->getRepository('AppBundle:Taxref')->getLastUpdate();

        $taxref = new Taxref();
        $form = $this->createForm(TaxrefType::class, $taxref);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Upload et enregistrement des informations en Bdd
            $em->persist($taxref);
            $em->flush();
            $this->addFlash('success', "Le fichier a été uploadé sur le serveur!!");

            return $this->redirectToRoute('manageBdd');
        }
        return $this->render('admin/manageBdd.html.twig', ['form' => $form->createView(), 'fileBdd' => $fileBdd, 'lastUpdate' => $lastUpdate]);
    }

    /**
     *
     * @Route("updateBdd", name="updateBdd")
     */
    public function updateBddAction()
    {
        $em = $this->getDoctrine()->getManager();
        $fileBdd = $em->getRepository('AppBundle:Taxref')->getLast();

        // 1) On parse le fichier CSV pour récupérer toutes les lignes
        // Utiliation d'un service pour parser le fichier
        $parseFile = $this->container->get('parse_file_csv');

        $contentCSV = $parseFile->parsefile($this->get('kernel')->getRootDir() . '/../web/taxref/' . $fileBdd->getCsvName());

        if ($contentCSV === false) {
            $this->addFlash('danger', "Le fichier n'est pas valide !!");

            return $this->redirectToRoute('manageBdd');
        }

        // On récupère le service pour les vérifications sur le fichier
        $checkFile = $this->container->get('check_file');

        // Vérification des colonnes
        if ($checkFile->checkFileCol($contentCSV) === false) {
            $this->addFlash('danger', "Le fichier n'est pas valide !!");

            return $this->redirectToRoute('manageBdd');
        }
        // On retire la première ligne du tableau de données (REGNE, PHYLUM, ORDRE...)
        $first_row = array_shift($contentCSV);

        // 2) On vérifie pour chaque ligne si l'espèce existe
        // Si oui, on update la ligne
        // Si non, on la créée

        //die(var_dump($contentCSV));

        foreach ($contentCSV as $row) {
            $bird = new Bird();
            $birdExist = $em->getRepository('AppBundle:Bird')->findOneByCdRef($row['cd_ref']);

            if ($row['species'] !== '') {
                if ($birdExist === null) {
                    $bird->setSpecies($row['species']);
                    $bird->setReign($row['reign']);
                    $bird->setPhYlum($row['phylum']);
                    $bird->setRanking($row['ranking']);
                    $bird->setFamily($row['family']);
                    $bird->setLbName($row['lb_name']);
                    $bird->setLbAuthor($row['lb_author']);
                    $bird->setCdRef(($row['cd_ref']));
                    $em->persist($bird);
                } else {
                    $birdExist->setSpecies($row['species']);
                    $birdExist->setReign($row['reign']);
                    $birdExist->setPhYlum($row['phylum']);
                    $birdExist->setRanking($row['ranking']);
                    $birdExist->setFamily($row['family']);
                    $birdExist->setLbName($row['lb_name']);
                    $birdExist->setLbAuthor($row['lb_author']);
                }
            }
        }

        $fileBdd->setIsUpdate(true);
        $em->flush();

        $this->addFlash('success', "La base de données a été mise à jour!!");

        return $this->redirectToRoute('manageBdd');
    }

    /**
     * @Route("/gestion-comptes/{roles}", name="manageAccounts")
     * @param $roles
     *
     * @return Response
     */
    public function manageAccountsAction($roles) : Response
    {
        $em = $this->getDoctrine()->getManager();

        $accounts = [];
        switch ($roles) {
            case "tous":
                $accounts = $em->getRepository('AppBundle:User')->getUsers();
                return $this->render('admin/manageAccounts.html.twig', ['accounts' => $accounts]);
                break;
            case "user":
                $accounts = $em->getRepository('AppBundle:User')->getUser();
                return $this->render('admin/manageAccounts.html.twig', ['accounts' => $accounts]);
                break;
            case "naturalist":
                $accounts = $em->getRepository('AppBundle:User')->getOtherUser('ROLE_NATURALIST');
                return $this->render('admin/manageAccounts.html.twig', ['accounts' => $accounts]);
                break;
            case "editor":
                $accounts = $em->getRepository('AppBundle:User')->getOtherUser('ROLE_EDITOR');
                return $this->render('admin/manageAccounts.html.twig', ['accounts' => $accounts]);
                break;
            case "admin":
                $accounts = $em->getRepository('AppBundle:User')->getOtherUser('ROLE_ADMIN');
                return $this->render('admin/manageAccounts.html.twig', ['accounts' => $accounts]);
                break;
            case "block":
                $accounts = $em->getRepository('AppBundle:User')->findByEnabled(false);
                return $this->render('admin/manageAccounts.html.twig', ['accounts' => $accounts]);
                break;
            default:
                throw $this->createNotFoundException('Cette page n\'existe pas');
                break;
        }

        return $this->render('admin/manageAccounts.html.twig', ['accounts' => $accounts]);
    }

    /**
     * @param $id
     * @Route("/promotion-compte/{id}", name="promoteAccount")
     *
     * @return RedirectResponse
     */
    public function promoteAccountAction($id) : RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneById($id);

        $user->setRoles(["ROLE_NATURALIST"]);

        $em->persist($user);
        $em->flush();

        // envoi d'un mail pour indiquer aux editors qu'un commentaire a été signalé
        // Récupération du service d'envoi de mail
        $mailer = $this->container->get('send_mail');

        $objet = [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'username' => $user->getUsername()
        ];

        $admins = $em->getRepository('AppBundle:User')->getUserAdmin();

        // envoi du mail aux admins
        foreach ($admins as $admin) {
            $mailer->sendMessage(
                $admin->getEmail(),
                'Promotion du compte',
                'mail/account-promote-model.html.twig',
                'teamp5.oc.cpm@gmail.com',
                $objet
            );
        }
        // envoi du mail à l'utilisateur
        $mailer->sendMessage(
            $user->getEmail(),
            'Promotion de votre compte',
            'mail/account-promote-model.html.twig',
            'teamp5.oc.cpm@gmail.com',
            $objet
        );

        $this->addFlash('success', $user->getUsername() . " à bien été promu naturaliste.");

        return $this->redirectToRoute('manageAccounts', ['roles' => "tous"]);
    }

    /**
     * @param $id
     * @Route("/bloquer-compte/{id}", name="blockAccount")
     *
     * @return RedirectResponse
     */
    public function blockAccountAction($id) : RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneById($id);

        $user->setEnabled(false);

        $em->persist($user);
        $em->flush();

        // envoi d'un mail pour indiquer aux editors qu'un commentaire a été signalé
        // Récupération du service d'envoi de mail
        $mailer = $this->container->get('send_mail');

        $objet = [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'username' => $user->getUsername()
        ];

        // envoi du mail à l'utilisateur
        $mailer->sendMessage(
            $user->getEmail(),
            'Compte bloqué',
            'mail/account-blocked-model.html.twig',
            'teamp5.oc.cpm@gmail.com',
            $objet
        );

        $this->addFlash('success', $user->getUsername() . " à bien été bloqué.");

        return $this->redirectToRoute('manageAccounts', ['roles' => "tous"]);
    }
    /**
     * @param $id
     * @Route("/activer-compte/{id}", name="activateAccount")
     *
     * @return RedirectResponse
     */
    public function activateAccountAction($id) : RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneById($id);

        $user->setEnabled(true);

        $em->persist($user);
        $em->flush();

        // envoi d'un mail pour indiquer aux editors qu'un commentaire a été signalé
        // Récupération du service d'envoi de mail
        $mailer = $this->container->get('send_mail');

        $objet = [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'username' => $user->getUsername()
        ];

        // envoi du mail à l'utilisateur
        $mailer->sendMessage(
            $user->getEmail(),
            'Compte activé',
            'mail/account-activated-model.html.twig',
            'teamp5.oc.cpm@gmail.com',
            $objet
        );

        $this->addFlash('success', $user->getUsername() . " à bien été activé.");
        return $this->redirectToRoute('manageAccounts', ['roles' => "tous"]);
    }

    /**
     * @param $id
     * @Route("/supprimer-compte/{id}", name="removeAccount")
     *
     * @return RedirectResponse
     */
    public function removeAccountAction($id) : RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->findOneById($id);

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', $user->getUsername() . " à bien été supprimé.");
        return $this->redirectToRoute('manageAccounts', ['roles' => "tous"]);
    }
}
