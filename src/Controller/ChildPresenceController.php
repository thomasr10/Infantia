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
    public function getPlanningForUser(ChildPresenceRepository $childPresenceRepository, DateRepository $dateRepository, RepresentativeRepository $representativeRepository): Response
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

    #[Route('/educateur/planning', name: 'app_educateur_planning')]
    public function getChildPresenceForEduc(ChildPresenceRepository $childPresenceRepository, DateRepository $dateRepository): Response
    {   
        $user = $this->getUser();
        $todaysDate = new \DateTime(date('Y-m-d'));
        $todaysDateEntity = $dateRepository->getTodaysDateEntity($todaysDate);
        $todaysPresence = $childPresenceRepository->getTodaysPresence($todaysDateEntity);
        
        $monday = clone $todaysDate;
        $startDate = $monday->modify('monday this week')->format('Y-m-d');
        $friday = clone $todaysDate;
        $endDate = $friday->modify('friday this week')->format('Y-m-d');

        $arrayDateEntity = $dateRepository->getDateEntitiesForAWeek($startDate, $endDate);
        $childPresence = [];

        foreach ($todaysPresence as $childPresenceEntity) {
            
            $fullName = $childPresenceEntity->getChild()->getFirstName() . ' ' . $childPresenceEntity->getChild()->getLastName();
            $weekPresence = $childPresenceRepository->getWeekPresenceFromChild($childPresenceEntity->getChild(), $arrayDateEntity);
    
            $totalHour = 0;
            $totalMin = 0;
            
            foreach ($weekPresence as $dayPresence) {
                $totalHour += intval($dayPresence->getExitHour()->format('H')) - $dayPresence->getEntranceHour()->format('H');
                $totalMin += intval($dayPresence->getExitHour()->format('i')) - $dayPresence->getEntranceHour()->format('i');
            }

            if($totalMin >= 60) {
                $totalHour += intdiv($totalMin, 60);
                $totalMin = $totalMin % 60;
            }

            $totalTime = $totalHour . 'h' . $totalMin;

            $age = $todaysDate->format('Y') - $childPresenceEntity->getChild()->getBirthDate()->format('Y');

            if ($age <= 1) {
                $age = $age . ' an';
            } else {
                $age = $age . ' ans';
            }

            $childPresence[$fullName] = [
                'entranceDate' => $childPresenceEntity->getChild()->getEntranceDate(),
                'age' => $age,
                'totalTime' => $totalTime,
                'days' => $arrayDateEntity,
                'presenceDays' => $weekPresence,
                'allergies' =>$childPresenceEntity->getChild()->getAllergy(),
                'gender' => $childPresenceEntity->getChild()->getGender(),
                'parent' => $childPresenceEntity->getChild()->getRepresentative()
            ];
        }

        return $this->render('child_presence/index.html.twig', [
            'childPresence' => $childPresence,
            'date' => $arrayDateEntity
        ]);
    }
}
