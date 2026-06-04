<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Renders Interfacing-owned welcome/access pages.
 *
 * Authentication, registration, and logout processing remain owned by the
 * security/access component. Interfacing owns only the visual page contract:
 * public welcome surface, no top/left/right shell panels, shared footer only.
 */
final class InterfaceWelcomeAccessController
{
    public function __construct(
        private readonly InterfaceRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing/access', name: 'interfacing_access_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->renderer->render('access/index.html.twig', [
            'screenId' => 'access.index',
            'accessPage' => 'index',
            'accessTitle' => 'Welcome',
            'accessSubtitle' => 'Choose how you want to continue.',
            'accessPrimaryAction' => 'Sign in',
            'accessFooterMode' => 'welcome-only',
            'shell' => null,
        ]);
    }

    #[Route('/access/signin', name: 'interfacing_welcome_sign_in', methods: ['GET'])]
    public function signIn(): Response
    {
        return $this->renderer->render('accessin/signin/index.html.twig', [
            'screenId' => 'accessin.signin',
            'accessPage' => 'sign-in',
            'accessTitle' => 'Sign in',
            'accessSubtitle' => 'Continue to your Smart Responsor workspace.',
            'accessPrimaryAction' => 'Sign in',
            'accessFooterMode' => 'welcome-only',
            'shell' => null,
        ]);
    }

    #[Route('/interfacing/access/sign-up', name: 'interfacing_welcome_sign_up', methods: ['GET'])]
    public function signUp(): Response
    {
        return $this->renderer->render('access/sign_up.html.twig', [
            'screenId' => 'access.sign-up',
            'accessPage' => 'sign-up',
            'accessTitle' => 'Create account',
            'accessSubtitle' => 'Start a new Smart Responsor workspace identity.',
            'accessPrimaryAction' => 'Create account',
            'accessFooterMode' => 'welcome-only',
            'shell' => null,
        ]);
    }

    /**
     * This route is intentionally GET-only. Real sign-out execution must remain
     * in the owning security/access component, typically as a POST/Logout route.
     */
    #[Route('/interfacing/access/sign-out', name: 'interfacing_welcome_sign_out', methods: ['GET'])]
    public function signOut(): Response
    {
        return $this->renderer->render('access/sign_out.html.twig', [
            'screenId' => 'access.sign-out',
            'accessPage' => 'sign-out',
            'accessTitle' => 'Sign out',
            'accessSubtitle' => 'You can return to the application or continue to the public welcome pages.',
            'accessPrimaryAction' => 'Return to sign in',
            'accessFooterMode' => 'welcome-only',
            'shell' => null,
        ]);
    }
}
