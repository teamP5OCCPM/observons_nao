<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="board")
     */
    public function boardAction(Request $request)
    {
        return $this->render('admin/board.html.twig');
    }

    /**
     * @Route("/mon-compte", name="myAccount")
     */
    public function myAccountAction(Request $request)
    {
        return $this->render('admin/myAccount.html.twig');
    }

    /**
     * @Route("/mon-observations", name="myObservations")
     */
    public function myObservationsAction(Request $request)
    {
        return $this->render('admin/myObservations.html.twig');
    }

    /**
     * @Route("/gestion-observations", name="manageObservations")
     */
    public function manageObservationsAction(Request $request)
    {
        return $this->render('admin/manageObservations.html.twig');
    }

    /**
     * @Route("/gestion-articles", name="manageArticles")
     */
    public function manageArticlesAction(Request $request)
    {
        return $this->render('admin/manageArticles.html.twig');
    }

    /**
     * @Route("/gestion-commentaires", name="manageComs")
     */
    public function manageComsAction(Request $request)
    {
        return $this->render('admin/manageComs.html.twig');
    }

    /**
     * @Route("/mise-a-jour-bdd", name="manageBdd")
     */
    public function manageBddAction(Request $request)
    {
        return $this->render('admin/manageBdd.html.twig');
    }

    /**
     * @Route("/gestion-comptes", name="manageAccounts")
     */
    public function manageAccountsAction(Request $request)
    {
        return $this->render('admin/manageAccounts.html.twig');
    }
}
