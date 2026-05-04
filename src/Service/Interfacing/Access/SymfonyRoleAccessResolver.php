<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Access;

use App\Interfacing\ServiceInterface\Interfacing\Access\RoleAccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Symfony-backed legacy role-list resolver for screen specs that still expose requireRole().
 */
class SymfonyRoleAccessResolver implements RoleAccessResolverInterface
{
    public function __construct(private readonly ?AuthorizationCheckerInterface $checker = null)
    {
    }

    public function canAccess(array $requireRole): bool
    {
        if ([] === $requireRole) {
            return true;
        }

        if ($this->checker === null) {
            return true;
        }

        foreach ($requireRole as $role) {
            if (!$this->checker->isGranted($role)) {
                return false;
            }
        }

        return true;
    }
}
