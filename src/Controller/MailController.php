<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;


final class MailController extends AbstractController
{
    #[Route('/admin/mail/new-user', name: 'app_mail_new_user')]
    public function sendEmailToNewUser(Request $request, UserRepository $userRepository, MailerInterface $mailer): Response
    {   
        $email = $request->query->get('email');
        $user = $userRepository->findOneByEmail($email);

        $newEmail = (new Email())
            ->from('no-reply@infantia.com')
            ->to($email)
            ->subject('Confirmez votre inscription')
            ->html('<p>Bonjour, veuillez confirmer votre inscription en créant votre mot de passe en cliquant sur ce <a href="http://127.0.0.1:8000/user/create-password/' . $user->getId() . '">lien</a>.</p>');
        $mailer->send($newEmail);
        
        return $this->render('mail/index.html.twig');
    }

}
