<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdministrateurSecurityController extends AbstractController
{
    public const LAST_EMAIL = 'admin_last_email';

    #[Route('/administrateur/login', name: 'app_administrateur_login')]
    public function login(): Response
    {
        return $this->render('administrateur/security/login.html.twig');
    }

    #[Route('/administrateur/logout', name: 'app_administrateur_logout')]
    public function logout(): void
    {
        // Cette méthode peut rester vide.
        // Symfony intercepte automatiquement cette route grâce à la configuration "logout" dans security.yaml
        throw new \LogicException('Cette méthode peut être vide - elle sera interceptée par la clé logout du firewall.');
    }
}