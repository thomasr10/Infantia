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


final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ChildRepository $childRepository, RepresentativeRepository $representativeRepository, DateRepository $dateRepository, ChildPresenceRepository $childPresenceRepository): Response
    {   
        $user = $this->getUser();

        if ($user && in_array('ROLER_PARENT', $user->getRoles())) {
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

            //régime spéciaux du jour

            $childAllergy = [];

            foreach ($todaysPresence as $childPresence) {
                $child = $childPresence->getChild();
                $childAllergy[$child->getFirstName()] = [];

                foreach ($child->getAllergy() as $allergy) {
                    $childAllergy[$child->getFirstName()][] = $allergy->getName();
                }
    
            }
            var_dump($childAllergy);
        }
        
        if (!$this->getUser()) {
            return $this->render('home/index-unco.html.twig');

        } else {
            // parent
            if (in_array('ROLE_PARENT', $user->getRoles())) {
                return $this->render('home/index-co.html.twig', [
                    'parent' => $representative->getId()
                ]);
            }

            // admin
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                return $this->render('home/index-co.html.twig', [
                    'countChildPresence' => $countTodaysPresence,
                    'childAllergy' => $childAllergy || 'Aucun régime spécial aujourd\'hui' // à revoir
                ]);
            }

            // educateur
            if (in_array('ROLE_EDUCATOR', $user->getRoles())) {
                return $this->render('home/index-co.html.twig');
            }

        }

    }
}
