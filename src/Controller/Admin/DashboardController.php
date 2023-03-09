<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;



class DashboardController extends AbstractDashboardController
{
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->render('content/content.html.twig');
    }

    

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Mon Dashboard Utilisateur personnalisé')
            ->setFaviconPath('/path/to/favicon.ico');
            
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Contacts', 'fa fa-address-book');
        yield MenuItem::linkToRoute('Liste des contacts', 'fa fa-list', 'liste_contacts');
        

        // Vérifie si l'utilisateur a le rôle "ROLE_ADMIN"
        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Gestion des utilisateurs', 'fa fa-users');
            yield MenuItem::linkToRoute('Liste des utilisateurs', 'fas fa-list', 'user_index');
        }
    }

}
