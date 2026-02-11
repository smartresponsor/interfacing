<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing;

use App\Domain\Interfacing\Model\AccessRule;
use App\ServiceInterface\Interfacing\AccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 *
 */

/**
 *
 */
final class SymfonyAccessResolver implements AccessResolverInterface
{
    /**
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $checker
     */
    public function __construct(private readonly AuthorizationCheckerInterface $checker) {}

    /**
     * @param \App\Domain\Interfacing\Model\AccessRule $rule
     * @return bool
     */
    public function canAccess(AccessRule $rule): bool
    {
        foreach ($rule->requireRoleList() as $role) {
            if (!$this->checker->isGranted($role)) {
                return false;
            }
        }
        return true;
    }
}
