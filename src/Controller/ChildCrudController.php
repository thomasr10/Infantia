<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\ChildPresence;
use App\Form\ChildForm;
use App\Repository\ChildRepository;
use App\Repository\TeamRepository;
use App\Repository\RepresentativeRepository;
use App\Repository\DateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/child/crud')]
final class ChildCrudController extends AbstractController
{
    #[Route(name: 'app_child_crud_index', methods: ['GET'])]
    public function index(ChildRepository $childRepository): Response
    {
        return $this->render('child_crud/index.html.twig', [
            'children' => $childRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_child_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, RepresentativeRepository $representativeRepository, DateRepository $dateRepository, TeamRepository $teamRepository): Response
    {
        $child = new Child();
        $form = $this->createForm(ChildForm::class, $child);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager->persist($child);
            
            // add representative_child
            $representativeId = $request->request->get('representativeId');

            $representativeEntity = $representativeRepository->findOneById($representativeId);
            $child->addRepresentative($representativeEntity);

            // add child_presence
            
            $presenceData = $request->request->all('presence');
            $days = [];

            foreach ($presenceData as $day => $data) {

                if ($day === 'lun') {
                    $day = 'Lundi';
                }
                if ($day === 'mar') {
                    $day = 'Mardi';
                }
                if ($day === 'mer') {
                    $day = 'Mercredi';
                }
                if ($day === 'jeu') {
                    $day = 'Jeudi';
                }
                if ($day === 'ven') {
                    $day = 'Vendredi';
                }

                $days[] = $day;
            }

            $entranceDate = new \DateTime($request->request->all('child_form')['entrance_date']);
            
            $arrayDateEntity = $dateRepository->getDateEntityFromDays($days, $entranceDate);

            $dayMap = [
                'Lundi' => 'lun',
                'Mardi' => 'mar',
                'Mercredi' => 'mer',
                'Jeudi' => 'jeu',
                'Vendredi' => 'ven',
            ];
            
            foreach ($arrayDateEntity as $date) {
                $day = $date->getDay();
                $shortDay = $dayMap[$day];

                $entranceHour = $presenceData[$shortDay]['entrance_hour'];
                $exitHour = $presenceData[$shortDay]['exit_hour'];

                $childPresence = new ChildPresence();
                $childPresence->setDate($date);
                $childPresence->setChild($child);
                $childPresence->setEntranceHour(new \DateTime($entranceHour));
                $childPresence->setExitHour(new \DateTime($exitHour));
                $entityManager->persist($childPresence);

            }

            // add child_team

            $birthDate = new \DateTime($request->request->all('child_form')['birth_date']);
            $diff = $entranceDate->diff($birthDate);
            $age = $diff->y;
            
            $team = $teamRepository->getTeamFromChildAge($age);
            $child->setTeam($team);

            $entityManager->flush();
            
            return $this->redirectToRoute('app_child_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('child_crud/new.html.twig', [
            'child' => $child,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_child_crud_show', methods: ['GET'])]
    public function show(Child $child): Response
    {
        return $this->render('child_crud/show.html.twig', [
            'child' => $child,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_child_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Child $child, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChildForm::class, $child);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_child_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('child_crud/edit.html.twig', [
            'child' => $child,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_child_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Child $child, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$child->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($child);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_child_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
