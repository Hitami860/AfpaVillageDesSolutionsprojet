<?php

namespace App\Controller;

use App\Entity\Interventions;
use App\Repository\InterventionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'app_calendar')]
    public function calendarinterventions(EntityManagerInterface $entity): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $intervention = $entity->getRepository(Interventions::class)->findAll();


        foreach ($intervention as $interventions) {
            $interv[] = [
                "title" => $interventions->getPartner()->getName(),
                "start" => $interventions->getDate(),
                "end" => $interventions->getEnddate(),
            ];
        }

        return $this->render('calendar/calendar.html.twig', [
            'controller_name' => 'CalendarController',
            'intervention' => $interv,
        ]);
    }

    #[Route('/calendar/date', name: 'app_calendarJson')]
    public function jsonCalendar(EntityManagerInterface $entity): JsonResponse
    {
        $intervention = $entity->getRepository(Interventions::class)->findAll();


        foreach ($intervention as $interventions) {
            $interv[] = [
                "title" => $interventions->getPartner()->getName(),
                "start" => $interventions->getDate(),
                "end" => $interventions->getEnddate(),
                "description" => $interventions->getDescription(),
                "places" => $interventions->getPlaces(),
            ];
        }

        return $this->json($interv);
    }
}
