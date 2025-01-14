<?php

namespace App\Controller;

use App\Entity\Problematic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProblematicController extends AbstractController
{
    #[Route('/problematic', name: 'app_problematic')]
    public function index( EntityManagerInterface $entity): Response
    {
        $problematics = $entity->getRepository(Problematic::class)->findAll();
        return $this->render('problematic/problematic.html.twig', [
            'controller_name' => 'ProblematicController',
            'problematics' => $problematics,
        ]);
    }
}
