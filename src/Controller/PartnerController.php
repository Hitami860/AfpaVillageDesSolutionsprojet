<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Entity\Interventions;
use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\ActivitiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PartnerController extends AbstractController
{
    #[Route('/partner', name: 'app_partner')]
    public function partner(EntityManagerInterface $entity): Response
    {
        $partner = $entity->getRepository(Partner::class)->findAll();
        return $this->render('partner/partner.html.twig', [
            'controller_name' => 'PartnerController',
            'partner' => $partner,
        ]);
    }

    #[Route('/partner/{id}', name: 'app_partner')]
    public function partnerid($id, EntityManagerInterface $entity, Request $request, PaginatorInterface $paginatorInterface): Response
    {

        // $partner = $entity->getRepository(Partner::class)->findAll();
        $partner = $entity->getRepository(Partner::class)->findOneBy(['id' => $id]);
        $interventions = $entity->getRepository(Interventions::class)->findBy(['partner' => $partner]);
        $activities = $entity->getRepository(Activities::class)->findBy(['partner' => $partner]);

        // $partner = $this->getUser()->getPartner();
        $interventions = $partner->getInterventions();

        $interv = $paginatorInterface->paginate(
            $interventions,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('partner/partner.html.twig', [
            'controller_name' => 'PartnerController',
            'id' => $id,
            'partner' => $partner,
            'interventions' => $interventions,
            'activities' => $activities,
            'interv' => $interv,
        ]);
    }
}
