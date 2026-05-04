<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Security;

use App\Interfacing\Contract\View\ScreenSpecInterface;
use App\Interfacing\ServiceInterface\Interfacing\Security\ScreenAccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Symfony-backed access resolver for declarative ScreenSpec view contracts.
 */
class SymfonyScreenAccessResolver implements ScreenAccessResolverInterface
{
    public function __construct(
        private readonly ?AuthorizationCheckerInterface $authorizationChecker = null,
    ) {
    }

    public function isAllowed(ScreenSpecInterface $screen): bool
    {
        $roles = $screen->requireRole();
        if ([] === $roles) {
            return true;
        }

        if ($this->authorizationChecker === null) {
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
