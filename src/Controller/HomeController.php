<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use App\Repository\ChildRepository;
use App\Repository\ChildPresenceRepository;
use App\Repository\RepresentativeRepository;
use App\Repository\DateRepository;
use App\Repository\ScheduledActivityRepository;


final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ChildRepository $childRepository, RepresentativeRepository $representativeRepository, DateRepository $dateRepository, ChildPresenceRepository $childPresenceRepository, ScheduledActivityRepository $scheduledActivityRepository): Response
    {   
        $user = $this->getUser();

        if ($user && in_array('ROLE_PARENT', $user->getRoles())) {
            $representative = $representativeRepository->getRepresentativeFromUser($user);

            foreach ($representative->getChildren() as $child) {
                var_dump($child->getFirstName());
            }            
        }

        if ($user && in_array('ROLE_ADMIN', $user->getRoles())) {
            // récupérer le nombre d'enfants présents aujourd'hui

            $todaysDate = new \DateTime(date('Y-m-d'));
            $todaysDateEntity = $dateRepository->getTodaysDateEntity($todaysDate);
            $todaysPresence = $childPresenceRepository->getTodaysPresence($todaysDateEntity);
            $countTodaysPresence = count($todaysPresence);

            //régime spéciaux du jour et anniversaires

            $childAllergy = [];
            $childBirthday = [];

            foreach ($todaysPresence as $childPresence) {
                $child = $childPresence->getChild();
                $firstName = $child->getFirstName();
                $allergies = $child->getAllergy();

                if (count($allergies) > 0) {
                    foreach ($allergies as $allergy) {
                        $childAllergy[$firstName][] = $allergy->getName();
                    }
                }

                if ($child->getBirthdate()->format('Y-m-d') === $todaysDate) {
                    $childBirthday[] = $child->getFirstName();
                }
            }

            // Programme du jour

            $todayProgram = $scheduledActivityRepository->getTodayProgram($todaysDateEntity);
            $team1Program = [];
            $team2Program = [];
            $team3Program = [];

            foreach ($todayProgram as $program) {
                if ($program->getTeam()->getName() === 'Les Papillons') {
                    $team1Program[] = $program;
                }
                if ($program->getTeam()->getName() === 'Les Oursons') {
                    $team2Program[] = $program;
                }
                if ($program->getTeam()->getName() === 'Les Castors') {
                    $team3Program[] = $program;
                }
            }

            // nombre d'enfants inscrits

            $allChildren = $childRepository->getAllChildren();
            $countAllChildren = count($allChildren);

        }
        
        if (!$this->getUser()) {
            return $this->render('home/index-unco.html.twig');

        } else {
            // parent
            if (in_array('ROLE_PARENT', $user->getRoles())) {
                return $this->render('home/index-co.html.twig', [
                    
                ]);
            }

            // admin
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                return $this->render('home/index-co.html.twig', [
                    'countChildPresence' => $countTodaysPresence,
                    'childAllergy' => !empty($childAllergy) ? $childAllergy : 'Aucun régime spécial aujourd\'hui',
                    'childBirthday' => !empty($childBirthday) ? $childBirthday : 'Aucun anniversaire aujourd\'hui',
                    'totalChildren' => $countAllChildren,
                    'programPapillons' => $team1Program,
                    'programOursons' => $team2Program,
                    'programCastors' => $team3Program,
                ]);
            }

            // educateur
            if (in_array('ROLE_EDUCATOR', $user->getRoles())) {
                return $this->render('home/index-co.html.twig');
            }

        }

    }
}
