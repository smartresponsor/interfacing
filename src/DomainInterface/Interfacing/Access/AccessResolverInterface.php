Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\DomainInterface\Interfacing\Access;

use App\Domain\Interfacing\Access\AccessDecision;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

interface AccessResolverInterface
{
    public function canOpenScreen(string $screenId, Request $request, ?TokenInterface $token): AccessDecision;

    public function canRunAction(string $screenId, string $actionId, Request $request, ?TokenInterface $token): AccessDecision;
}
