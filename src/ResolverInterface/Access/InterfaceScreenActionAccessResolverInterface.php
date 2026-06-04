<?php

declare(strict_types=1);

namespace App\Interfacing\ResolverInterface\Access;

use App\Interfacing\Contract\Access\InterfaceAccessDecision;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Request-aware access resolver for opening screens and running screen actions.
 */
interface InterfaceScreenActionAccessResolverInterface
{
    public function canOpenScreen(string $screenId, Request $request, ?TokenInterface $token): InterfaceAccessDecision;

    public function canRunAction(string $screenId, string $actionId, Request $request, ?TokenInterface $token): InterfaceAccessDecision;
}
