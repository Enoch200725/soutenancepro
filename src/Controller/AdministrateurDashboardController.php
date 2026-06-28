<?php

namespace App\Controller;

use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\SalleRepository;
use App\Repository\SoutenanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdministrateurDashboardController extends AbstractController
{
    #[Route('/administrateur', name: 'app_administrateur_dashboard')]
    public function index(
        EtudiantRepository $etudiantRepository,
        EnseignantRepository $enseignantRepository,
        SalleRepository $salleRepository,
        SoutenanceRepository $soutenanceRepository
    ): Response {
        return $this->render('administrateur/dashboard/index.html.twig', [
            'nbEtudiants' => count($etudiantRepository->findAll()),
            'nbEnseignants' => count($enseignantRepository->findAll()),
            'nbSalles' => count($salleRepository->findAll()),
            'nbSoutenances' => count($soutenanceRepository->findAll()),
        ]);
    }
}