<?php

namespace App\Controller;

use App\Entity\TrustedPerson;
use App\Form\TrustedPersonForm;
use App\Repository\TrustedPersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('admin/trusted/person/crud')]
final class TrustedPersonCrudController extends AbstractController
{
    #[Route(name: 'app_trusted_person_crud_index', methods: ['GET'])]
    public function index(TrustedPersonRepository $trustedPersonRepository): Response
    {
        return $this->render('trusted_person_crud/index.html.twig', [
            'trusted_people' => $trustedPersonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_trusted_person_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trustedPerson = new TrustedPerson();
        $form = $this->createForm(TrustedPersonForm::class, $trustedPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trustedPerson);
            $entityManager->flush();

            return $this->redirectToRoute('app_trusted_person_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trusted_person_crud/new.html.twig', [
            'trusted_person' => $trustedPerson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trusted_person_crud_show', methods: ['GET'])]
    public function show(TrustedPerson $trustedPerson): Response
    {
        return $this->render('trusted_person_crud/show.html.twig', [
            'trusted_person' => $trustedPerson,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_trusted_person_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TrustedPerson $trustedPerson, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrustedPersonForm::class, $trustedPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_trusted_person_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trusted_person_crud/edit.html.twig', [
            'trusted_person' => $trustedPerson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trusted_person_crud_delete', methods: ['POST'])]
    public function delete(Request $request, TrustedPerson $trustedPerson, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trustedPerson->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($trustedPerson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_trusted_person_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
