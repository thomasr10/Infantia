<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ChildPresenceRepository;
use App\Repository\DateRepository;
use App\Repository\RepresentativeRepository;

final class ChildPresenceController extends AbstractController
{   
    #[Route('/parent/child/planning', name: 'app_child_presence')]
    public function getPlanning(ChildPresenceRepository $childPresenceRepository, DateRepository $dateRepository, RepresentativeRepository $representativeRepository): Response
    {
        $user = $this->getUser();
        $representative = $representativeRepository->getRepresentativeFromUser($user);
        $children = $representative->getChildren();

        $todaysDate = new \DateTime(date('Y-m-d'));

        $childPresence = [];

        $monday = clone $todaysDate;
        $startDate = $monday->modify('monday this week')->format('Y-m-d');
        $friday = clone $todaysDate;
        $endDate = $friday->modify('friday this week')->format('Y-m-d');

        $arrayDateEntity = $dateRepository->getDateEntitiesForAWeek($startDate, $endDate);
        
        foreach ($children as $childEntity) {
            $firstName = $childEntity->getFirstName();
            $childPresence[$firstName] = [];

            $childPresence[$firstName] = $childPresenceRepository->getWeekPresenceFromChild($childEntity, $arrayDateEntity);
        }
        
        return $this->render('child_presence/index.html.twig', [
            'calendar' => $arrayDateEntity,
            'childPresence' => $childPresence
        ]);
    }
}
