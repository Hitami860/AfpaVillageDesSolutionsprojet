<?php

namespace App\Controller\Admin;

use App\Entity\Activities;
use App\Entity\Categories;
use App\Entity\Interventions;
use App\Entity\Partner;
use App\Entity\Problematic;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        if (!$this->isGranted('ROLE_AFPA')) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette page!");
        }
        {return $this->render('admin/admin.html.twig');}
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Village Des Solutions');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Comptes', 'fas fa-list', Users::class);
        yield MenuItem::linkToCrud('Problematic', 'fas fa-list', Problematic::class);
        yield MenuItem::linkToCrud('Partner', 'fas fa-list', Partner::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Categories::class);
        // yield MenuItem::linkToCrud('Activities', 'fas fa-list', Activities::class);
    }
}
