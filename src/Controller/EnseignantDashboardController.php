<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Repository\SoutenanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EnseignantDashboardController extends AbstractController
{
    #[Route('/enseignant', name: 'app_enseignant_dashboard')]
    public function index(SoutenanceRepository $soutenanceRepository): Response
    {
        /** @var Enseignant $enseignant */
        $enseignant = $this->getUser();

        $nbSoutenances = count($soutenanceRepository->findByEnseignant($enseignant));

        return $this->render('enseignant/dashboard/index.html.twig', [
            'nbSoutenances' => $nbSoutenances,
        ]);
    }
}