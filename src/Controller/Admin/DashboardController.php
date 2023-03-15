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
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\UserCrudController;





class DashboardController extends AbstractDashboardController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->render('content/content.html.twig');
    }

    

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Masquie')
            ->setFaviconPath('/images/logo/mask.ico')
            ->disableDarkMode()
            ->renderContentMaximized();
    
            
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        
        return parent::configureUserMenu($user)
            ->setName($user->getFirstName())
            ->displayUserName(true)
            ->displayUserAvatar(true)
            ->setGravatarEmail($user->getEmail())
            ->addMenuItems([
                MenuItem::linkToRoute('Mon Profil', 'fa fa-id-card', 'app_profile_user'),
            ]);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Contacts', 'fa fa-address-book');
        yield MenuItem::linkToRoute('Liste des contacts', 'fa-solid fa-user-group', 'liste_contacts');
        yield MenuItem::linkToRoute('Mes contacts', 'fa-solid fa-people-group', 'user_contacts');
        

        // Checks if the user has the role "ROLE_ADMIN"
        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::section('Gestion des utilisateurs', 'fa fa-users');
            yield MenuItem::linkToCrud('Liste des utilisateurs', 'fa-solid fa-rectangle-list', User::class)
            ->setController(UserCrudController::class);
        }
    }

}
