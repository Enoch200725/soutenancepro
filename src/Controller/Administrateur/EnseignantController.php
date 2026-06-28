<?php

namespace App\Controller\Administrateur;

use App\Entity\Enseignant;
use App\Form\EnseignantFormType;
use App\Repository\EnseignantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/administrateur/enseignants')]
class EnseignantController extends AbstractController
{
    #[Route('', name: 'app_administrateur_enseignant_index', methods: ['GET'])]
    public function index(EnseignantRepository $enseignantRepository): Response
    {
        return $this->render('administrateur/enseignant/index.html.twig', [
            'enseignants' => $enseignantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_administrateur_enseignant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $enseignant = new Enseignant();
        $form = $this->createForm(EnseignantFormType::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword($enseignant, 'enseignant123');
            $enseignant->setPassword($hashedPassword);
            $enseignant->setRoles([]);

            $entityManager->persist($enseignant);
            $entityManager->flush();

            return $this->redirectToRoute('app_administrateur_enseignant_index');
        }

        return $this->render('administrateur/enseignant/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_administrateur_enseignant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Enseignant $enseignant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EnseignantFormType::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_administrateur_enseignant_index');
        }

        return $this->render('administrateur/enseignant/edit.html.twig', [
            'enseignant' => $enseignant,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_administrateur_enseignant_delete', methods: ['POST'])]
    public function delete(Request $request, Enseignant $enseignant, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($enseignant);
        $entityManager->flush();

        return $this->redirectToRoute('app_administrateur_enseignant_index');
    }
}