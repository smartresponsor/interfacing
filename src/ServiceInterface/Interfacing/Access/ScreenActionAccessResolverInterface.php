<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Access;

use App\Interfacing\Contract\Access\AccessDecision;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Request-aware access resolver for opening screens and running screen actions.
 */
interface ScreenActionAccessResolverInterface
{
    public function canOpenScreen(string $screenId, Request $request, ?TokenInterface $token): AccessDecision;

    public function canRunAction(string $screenId, string $actionId, Request $request, ?TokenInterface $token): AccessDecision;
}
