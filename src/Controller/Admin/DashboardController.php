<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
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
            ->setTitle('Home')
            ->setFaviconPath('/path/to/favicon.ico')
            ->disableDarkMode()
            ->renderContentMaximized();
    
            
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {


        
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getFirstName())
            // use this method if you don't want to display the name of the user
            ->displayUserName(true)

            // you can return an URL with the avatar image
            // ->setAvatarUrl('https://...')
            // ->setAvatarUrl($profileImageUrl)
            // use this method if you don't want to display the user image
            ->displayUserAvatar(true)
            // you can also pass an email address to use gravatar's service
            ->setGravatarEmail($user->getEmail())

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('Mon Profil', 'fa fa-id-card', 'app_profile_user'),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', 'app_profile_user'),
                MenuItem::section(),
                // MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Contacts', 'fa fa-address-book');
        yield MenuItem::linkToRoute('Liste des contacts', 'fa fa-list', 'liste_contacts');
        yield MenuItem::linkToRoute('Mes contacts', 'fa fa-list', 'user_contacts');
        

        // Vérifie si l'utilisateur a le rôle "ROLE_ADMIN"
        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Gestion des utilisateurs', 'fa fa-users');
            yield MenuItem::linkToRoute('Liste des utilisateurs', 'fas fa-list', 'user_index');
        }
    }

}
