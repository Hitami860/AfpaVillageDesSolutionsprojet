<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Partner;
use App\Entity\Problematic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function problematics(EntityManagerInterface $entity): Response
    {
        
        $partner = $entity->getRepository(Partner::class)->findAll();
        $categories = $entity->getRepository(Categories::class)->findAll();
        $problematics = $entity->getRepository(Problematic::class)->findAll();
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'problematics' => $problematics,
            'categories' => $categories,
            'partner' => $partner,
        ]);
    }
    

    #[Route('/partner/{id}', name: 'app_partner')]
    public function partnerid($id, EntityManagerInterface $entity): Response
    {
        $partners = $entity->getRepository(Partner::class)->findOneBy(['id' => $id]);
        return $this->render('partner/partner.html.twig', [
            'controller_name' => 'PartnerController',
            'id' => $id,
            'partners' => $partners,
        ]);
    }

}
