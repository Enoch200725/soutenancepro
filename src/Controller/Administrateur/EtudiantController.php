<?php

namespace App\Controller\Administrateur;

use App\Entity\Etudiant;
use App\Entity\Soutenance;
use App\Form\EtudiantFormType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/administrateur/etudiants')]
class EtudiantController extends AbstractController
{
    #[Route('', name: 'app_administrateur_etudiant_index', methods: ['GET'])]
    public function index(Request $request, EtudiantRepository $etudiantRepository): Response
    {
        $nom = $request->query->get('nom');

        if ($nom) {
            $etudiants = $etudiantRepository->findBy(['nom' => $nom]);
        } else {
            $etudiants = $etudiantRepository->findAll();
        }

        return $this->render('administrateur/etudiant/index.html.twig', [
            'etudiants' => $etudiants,
        ]);
    }

    #[Route('/new', name: 'app_administrateur_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantFormType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etudiant);
            $entityManager->flush();

            return $this->redirectToRoute('app_administrateur_etudiant_index');
        }

        return $this->render('administrateur/etudiant/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_administrateur_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtudiantFormType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_administrateur_etudiant_index');
        }

        return $this->render('administrateur/etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_administrateur_etudiant_delete', methods: ['POST'])]
    public function delete(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        // Supprimer la soutenance liée en PREMIER et valider immédiatement en base
        $soutenance = $entityManager->getRepository(Soutenance::class)->findOneBy(['etudiant' => $etudiant]);

        if ($soutenance) {
            $entityManager->remove($soutenance);
            $entityManager->flush(); // flush 1 : soutenance supprimée en base
        }

        // Maintenant supprimer l'étudiant sans contrainte FK
        $entityManager->remove($etudiant);
        $entityManager->flush(); // flush 2 : étudiant supprimé en base

        return $this->redirectToRoute('app_administrateur_etudiant_index');
    }
}