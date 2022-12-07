<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\Tokens;
use App\Controller\Admin\UserCrudController;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(ArticlesCrudController::class)
            ->setController(TokensCrudController::class)
            ->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TokenApiPlatform');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Article');
        yield MenuItem::subMenu('', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter un article', 'fas fa-plus', Articles::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les articles', 'fas fa-eye', Articles::class)
        ]);

        yield MenuItem::section('Token');
        yield MenuItem::subMenu('', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter un token', 'fas fa-plus', Tokens::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les tokens', 'fas fa-eye', Tokens::class)
        ]);
    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->setDefaultSort([
                'id' => 'DESC',
            ]);
    }
}
