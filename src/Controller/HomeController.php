<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;


final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {   
        $user = $this->getUser();
        $first_name = $user?->getFirstName();

        if (!$this->getUser()) {
            return $this->render('home/index-client.html.twig');

        } else {
            return $this->render('home/index-back.html.twig');

        }

    }
}
