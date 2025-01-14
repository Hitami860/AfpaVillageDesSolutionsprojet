<?php

namespace App\Controller;

use App\Entity\Activities;
use App\Form\EditProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $entity): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $partner = $this->getUser()->getPartner();
        

        $activities = $entity->getRepository(Activities::class)->findBy(['partner' => $partner]);
        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'ProfileController',
            'activities'=>$activities,
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function editProfile(Request $request, EntityManagerInterface $entity): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $partner = $this->getUser()->getPartner();

        $form = $this->createForm(EditProfileType::class, $partner);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $entity->persist($partner);
            $entity->flush();

            // $this->addFlash("success", "Informations du profile ont été mises à jour !");

        }


        
        return $this->render('profile/editprofile.html.twig', [
            'controller_name' => 'ProfileController',
            'form' => $form->createView(),
        ]);
    }
}
