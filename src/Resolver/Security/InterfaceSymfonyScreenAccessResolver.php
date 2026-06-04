<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Resolver\Security;

use App\Interfacing\Contract\View\InterfaceScreenSpecInterface;
use App\Interfacing\ResolverInterface\Security\InterfaceScreenAccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Symfony-backed access resolver for declarative InterfaceScreenSpec view contracts.
 */
class InterfaceSymfonyScreenAccessResolver implements InterfaceScreenAccessResolverInterface
{
    public function __construct(
        private readonly ?AuthorizationCheckerInterface $authorizationChecker = null,
    ) {
    }

    public function isAllowed(InterfaceScreenSpecInterface $screen): bool
    {
        $roles = $screen->requireRole();
        if ([] === $roles) {
            return true;
        }

        if (null === $this->authorizationChecker) {
            return true;
        }

        foreach ($roles as $role) {
            if (!$this->authorizationChecker->isGranted($role)) {
                return false;
            }
        }

        return true;
    }
}
