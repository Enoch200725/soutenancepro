<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Repository\SoutenanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EnseignantJuryController extends AbstractController
{
    #[Route('/enseignant/mes-jurys', name: 'app_enseignant_jurys')]
    public function index(SoutenanceRepository $soutenanceRepository): Response
    {
        /** @var Enseignant $enseignant */
        $enseignant = $this->getUser();

        $soutenances = $soutenanceRepository->findByEnseignant($enseignant);

        return $this->render('enseignant/jury/index.html.twig', [
            'soutenances' => $soutenances,
            'enseignant' => $enseignant,
        ]);
    }
}