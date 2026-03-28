<?php

declare(strict_types=1);

namespace App\Service\Interfacing;

use App\ServiceInterface\Interfacing\AccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class SymfonyAccessResolver implements AccessResolverInterface
{
    public function __construct(private readonly AuthorizationCheckerInterface $checker)
    {
    }

    public function canAccess(array $requireRole): bool
    {
        foreach ($requireRole as $role) {
            if (!$this->checker->isGranted($role)) {
                return false;
            }
        }

        return true;
    }
}
