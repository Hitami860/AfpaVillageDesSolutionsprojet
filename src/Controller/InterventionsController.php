<?php

namespace App\Controller;

use App\Entity\Interventions;
use App\Entity\Partner;
use App\Entity\RegistrationInterventions;
use App\Form\InterventionsType;
use App\Repository\InterventionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InterventionsController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManagerInterface,
    ) {}

    #[Route('/interventions', name: 'app_interventions')]
    public function planInterevntions(Request $request, PaginatorInterface $paginatorInterface): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $intervention = new Interventions();
        $form = $this->createForm(InterventionsType::class, $intervention);
        $form->handleRequest($request);

        $partner = $this->getUser()->getPartner();
        $interventions = $partner->getInterventions();

        $interv = $paginatorInterface->paginate(
            $interventions,
            $request->query->getInt('page', 1),
            3
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $intervention->setPartner($this->getUser()->getPartner());
            $this->entityManagerInterface->persist($intervention);
            $this->entityManagerInterface->flush();

            $this->addFlash("success", "Ajout de l'intervention réussie !");

            return $this->redirectToRoute('app_interventions');
        }

        return $this->render('interventions/interventions.html.twig', [
            'controller_name' => 'InterventionsController',
            'form' => $form->createView(),
            'interventions' => $interventions,
            'interv' => $interv,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete')]
    public function deleteIntervention($id, EntityManagerInterface $entityManagerInterface): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $partner = $this->getUser()->getPartner();
        $interventions = $partner->getInterventions();
        $interventions = $entityManagerInterface->getRepository(Interventions::class)->find($id);

        $interventions->setPartner(null);

        $this->entityManagerInterface->remove($interventions);
        $this->entityManagerInterface->flush();

        $this->addFlash("delete", "Suppression de l'intervention réussit !");


        return $this->redirectToRoute('app_interventions', [
            'controller_name' => 'InterventionsController',
            'interventions' => $interventions,
        ]);
    }

    #[Route('/intervention/{id}', name: 'app_intervention_details')]
    public function interventionsDetails($id, EntityManagerInterface $entityManagerInterface): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $partner = $this->getUser()->getPartner();
        $interventions = $partner->getInterventions();
        $interventions = $entityManagerInterface->getRepository(Interventions::class)->find($id);
        $participants = $entityManagerInterface->getRepository(RegistrationInterventions::class)->findBy(['interventions'=> $interventions]);


        return $this->render('interventions/interventiondetails.html.twig', [
            'interventions' => $interventions,
            'id'=> $id,
            'participants'=> $participants,
        ]);
    }

    #[Route('/delete/participant/{id}', name: 'app_delete_participant')]
    public function deleteParticipant(RegistrationInterventions $registration, EntityManagerInterface $entity): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // $partner = $this->getUser()->getPartner();
        $intervention = $registration->getInterventions();
        if($intervention) {
            $actualPlaces = $intervention->getPlaces();
            $intervention->setPlaces($actualPlaces + 1);
            $entity->persist($intervention);
        }
        

        $entity->remove($registration);
        $entity->flush();

        $this->addFlash("delete", "Suppression du participant réussit !");


        return $this->redirectToRoute('app_interventions', [
            'controller_name' => 'InterventionsController',
            'intervention' => $intervention,
        ]);
    }
}