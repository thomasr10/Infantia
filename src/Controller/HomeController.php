<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use App\Repository\ChildRepository;
use App\Repository\RepresentativeRepository;


final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ChildRepository $childRepository, RepresentativeRepository $representativeRepository): Response
    {   
        $user = $this->getUser();

        if ($user && in_array('ROLER_PARENT', $user->getRoles()) ) {
            $representative = $representativeRepository->getRepresentativeFromUser($user);
            
            foreach ($representative->getChildren() as $child) {
                var_dump($child->getFirstName());
            }            
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
                return $this->render('home/index-co.html.twig');
            }

            // educateur
            if (in_array('ROLE_EDUCATOR', $user->getRoles())) {
                return $this->render('home/index-co.html.twig');
            }

        }

    }
}
