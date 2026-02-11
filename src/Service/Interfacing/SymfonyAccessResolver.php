<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing;

use App\Domain\Interfacing\Model\AccessRule;
use App\ServiceInterface\Interfacing\AccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class SymfonyAccessResolver implements AccessResolverInterface
{
    public function __construct(private AuthorizationCheckerInterface $checker) {}

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
