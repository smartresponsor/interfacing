<?php

declare(strict_types=1);

namespace App\Interfacing\Resolver\Access;

use App\Interfacing\ResolverInterface\Access\InterfaceRoleAccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Symfony-backed legacy role-list resolver for screen specs that still expose requireRole().
 */
class InterfaceSymfonyRoleAccessResolver implements InterfaceRoleAccessResolverInterface
{
    public function __construct(private readonly ?AuthorizationCheckerInterface $checker = null)
    {
    }

    public function canAccess(array $requireRole): bool
    {
        if ([] === $requireRole) {
            return true;
        }

        if (null === $this->checker) {
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
