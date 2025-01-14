<?php

namespace App\Controller;

use App\Entity\RegistrationInterventions;
use App\Form\RegistrationInterventionsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationInterventionsController extends AbstractController
{
    #[Route('/registration/interventions', name: 'app_registration_interventions')]
    public function registrationform(Request $request, EntityManagerInterface $entity): Response
    {

        $registration = new RegistrationInterventions();

        $form = $this->createForm(RegistrationInterventionsType::class, $registration);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $intervention = $registration->getInterventions();

            if($intervention->getPlaces() > 0) {
                $intervention->setPlaces($intervention->getPlaces() - 1 );
            } else {
                $this->addFlash("registererror", "Désolé, il n'y a plus de places disponibles pour cette interventi");
                return $this->redirectToRoute('app_registration_interventions'); // Vous pouvez rediriger si nécessaire
            }
    

            $entity->persist($registration);
            $entity->persist($intervention);
            $entity->flush();

            $this->addFlash("registersuccess", "Inscription réalisé avec succés ! Vous allez recevoir un email de confirmation");
         }

        return $this->render('registration_interventions/registration.html.twig', [
            'controller_name' => 'RegistrationInterventionsController',
            'form' => $form->createView(),
        ]);
    }
}
