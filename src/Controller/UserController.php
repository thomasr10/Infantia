<?php

namespace App\Controller;

use App\Form\CreatePasswordForm;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends AbstractController
{
    #[Route('/user/create-password/{id}', name: 'app_user_create_password')]
    public function createPassword(int $id, Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {   
        $user = $userRepository->find($id);
        $form = $this->createForm(CreatePasswordForm::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $password);

            $user->setPassword($hashedPassword);
            $user->setIsVerified(true);
            $em->flush();
            $this->addFlash('success', 'Mot de passe mis à jour');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/create_password.html.twig', [ 'form' => $form->createView()]);
    }
}
