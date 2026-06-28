<?php

namespace App\Controller\Administrateur;

use App\Entity\Soutenance;
use App\Form\SoutenanceFormType;
use App\Repository\SoutenanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/administrateur/soutenances')]
class SoutenanceController extends AbstractController
{
    #[Route('', name: 'app_administrateur_soutenance_index', methods: ['GET'])]
    public function index(Request $request, SoutenanceRepository $soutenanceRepository): Response
    {
        $date = $request->query->get('date');

        if ($date) {
            $soutenances = $soutenanceRepository->findBy(['date' => new \DateTime($date)]);
        } else {
            $soutenances = $soutenanceRepository->findAll();
        }

        return $this->render('administrateur/soutenance/index.html.twig', [
            'soutenances' => $soutenances,
        ]);
    }

    #[Route('/new', name: 'app_administrateur_soutenance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SoutenanceRepository $soutenanceRepository): Response
    {
        $soutenance = new Soutenance();
        $form = $this->createForm(SoutenanceFormType::class, $soutenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $erreur = $this->verifierConflits($soutenance, $soutenanceRepository);

            if ($erreur) {
                $this->addFlash('errors', $erreur);
            } else {
                $entityManager->persist($soutenance);
                $entityManager->flush();

                return $this->redirectToRoute('app_administrateur_soutenance_index');
            }
        }

        return $this->render('administrateur/soutenance/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_administrateur_soutenance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Soutenance $soutenance, EntityManagerInterface $entityManager, SoutenanceRepository $soutenanceRepository): Response
    {
        $form = $this->createForm(SoutenanceFormType::class, $soutenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $erreur = $this->verifierConflits($soutenance, $soutenanceRepository);

            if ($erreur) {
                $this->addFlash('errors', $erreur);
            } else {
                $entityManager->flush();

                return $this->redirectToRoute('app_administrateur_soutenance_index');
            }
        }

        return $this->render('administrateur/soutenance/edit.html.twig', [
            'soutenance' => $soutenance,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_administrateur_soutenance_delete', methods: ['POST'])]
    public function delete(Request $request, Soutenance $soutenance, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($soutenance);
        $entityManager->flush();

        return $this->redirectToRoute('app_administrateur_soutenance_index');
    }

    /**
     * Vérifie les conflits de salle et d'enseignants pour une soutenance donnée.
     * Retourne un message d'erreur (string) s'il y a un conflit, ou null si tout est OK.
     */
    private function verifierConflits(Soutenance $soutenance, SoutenanceRepository $soutenanceRepository): ?string
    {
        $toutesSoutenances = $soutenanceRepository->findAll();

        foreach ($toutesSoutenances as $autre) {
            // On ignore la comparaison avec elle-même (cas de la modification)
            if ($autre->getId() === $soutenance->getId()) {
                continue;
            }

            $memeDate = $autre->getDate()?->format('Y-m-d') === $soutenance->getDate()?->format('Y-m-d');
            $memeHeure = $autre->getHeure()?->format('H:i') === $soutenance->getHeure()?->format('H:i');

            if ($memeDate && $memeHeure) {
                // Conflit de salle
                if ($autre->getSalle() === $soutenance->getSalle()) {
                    return 'Cette salle est déjà réservée à cette date et cette heure.';
                }

                // Conflit d'enseignant (président, rapporteur ou examinateur)
                $enseignantsAutre = [$autre->getPresident(), $autre->getRapporteur(), $autre->getExaminateur()];
                $enseignantsNouveau = [$soutenance->getPresident(), $soutenance->getRapporteur(), $soutenance->getExaminateur()];

                foreach ($enseignantsNouveau as $enseignant) {
                    if (in_array($enseignant, $enseignantsAutre, true)) {
                        return 'Un des enseignants sélectionnés est déjà membre d\'un autre jury à cette date et cette heure.';
                    }
                }
            }
        }

        return null;
    }
}