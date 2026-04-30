<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Security;

use App\Interfacing\Contract\View\ScreenSpecInterface;
use App\Interfacing\ServiceInterface\Interfacing\Security\AccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final readonly class SymfonyAccessResolver implements AccessResolverInterface
{
    public function __construct(
        private ?AuthorizationCheckerInterface $authorizationChecker = null,
    ) {
    }

    public function isAllowed(ScreenSpecInterface $screen): bool
    {
        $roles = $screen->requireRole();
        if ([] === $roles) {
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
