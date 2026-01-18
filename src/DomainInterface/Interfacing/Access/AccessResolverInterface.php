<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Access;

use SmartResponsor\Interfacing\Domain\Interfacing\Access\AccessDecision;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

interface AccessResolverInterface
{
    public function canOpenScreen(string $screenId, Request $request, ?TokenInterface $token): AccessDecision;

    public function canRunAction(string $screenId, string $actionId, Request $request, ?TokenInterface $token): AccessDecision;
}
