<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EnseignantSecurityController extends AbstractController
{
    public const LAST_EMAIL = 'enseignant_last_email';

    #[Route('/enseignant/login', name: 'app_enseignant_login')]
    public function login(): Response
    {
        return $this->render('enseignant/security/login.html.twig');
    }

    #[Route('/enseignant/logout', name: 'app_enseignant_logout')]
    public function logout(): void
    {
        // Cette méthode peut rester vide.
        // Symfony intercepte automatiquement cette route grâce à la configuration "logout" dans security.yaml
        throw new \LogicException('Cette méthode peut être vide - elle sera interceptée par la clé logout du firewall.');
    }
}