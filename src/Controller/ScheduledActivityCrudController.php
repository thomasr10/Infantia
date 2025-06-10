<?php

namespace App\Controller;

use App\Entity\ScheduledActivity;
use App\Form\ScheduledActivityForm;
use App\Repository\ScheduledActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/scheduled/activity/crud')]
final class ScheduledActivityCrudController extends AbstractController
{
    #[Route(name: 'app_scheduled_activity_crud_index', methods: ['GET'])]
    public function index(ScheduledActivityRepository $scheduledActivityRepository): Response
    {
        return $this->render('scheduled_activity_crud/index.html.twig', [
            'scheduled_activities' => $scheduledActivityRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scheduled_activity_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scheduledActivity = new ScheduledActivity();
        $form = $this->createForm(ScheduledActivityForm::class, $scheduledActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($scheduledActivity);
            $entityManager->flush();

            return $this->redirectToRoute('app_scheduled_activity_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scheduled_activity_crud/new.html.twig', [
            'scheduled_activity' => $scheduledActivity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scheduled_activity_crud_show', methods: ['GET'])]
    public function show(ScheduledActivity $scheduledActivity): Response
    {
        return $this->render('scheduled_activity_crud/show.html.twig', [
            'scheduled_activity' => $scheduledActivity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scheduled_activity_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ScheduledActivity $scheduledActivity, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ScheduledActivityForm::class, $scheduledActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_scheduled_activity_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scheduled_activity_crud/edit.html.twig', [
            'scheduled_activity' => $scheduledActivity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scheduled_activity_crud_delete', methods: ['POST'])]
    public function delete(Request $request, ScheduledActivity $scheduledActivity, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scheduledActivity->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($scheduledActivity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_scheduled_activity_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
