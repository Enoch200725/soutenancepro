<?php

namespace App\Security;

use App\Repository\EnseignantRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class EnseignantAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    private $urlGenerator;
    private $enseignantRepository;

    public function __construct(EnseignantRepository $enseignantRepository, UrlGeneratorInterface $urlGenerator)
    {
        $this->enseignantRepository = $enseignantRepository;
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'app_enseignant_login' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email');
        $enseignant = $this->enseignantRepository->findOneBy(['email' => $email]);

        if (!$enseignant) {
            throw new CustomUserMessageAuthenticationException('Email invalide');
        }

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password')),
            [new RememberMeBadge()]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->urlGenerator->generate('app_enseignant_dashboard'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->getFlashBag()->add('errors', 'Email ou mot de passe incorrect');

        return new RedirectResponse($this->urlGenerator->generate('app_enseignant_login'));
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        return new RedirectResponse($this->urlGenerator->generate('app_enseignant_login'));
    }
}