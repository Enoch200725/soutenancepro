<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Repository\SoutenanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EnseignantSoutenanceController extends AbstractController
{
    #[Route('/enseignant/mes-soutenances', name: 'app_enseignant_soutenances')]
    public function index(SoutenanceRepository $soutenanceRepository): Response
    {
        /** @var Enseignant $enseignant */
        $enseignant = $this->getUser();

        $soutenances = $soutenanceRepository->findByEnseignant($enseignant);

        return $this->render('enseignant/soutenance/index.html.twig', [
            'soutenances' => $soutenances,
        ]);
    }
}