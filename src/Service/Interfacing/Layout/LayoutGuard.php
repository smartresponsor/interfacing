<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Service\Interfacing\Layout;

use App\Contract\View\LayoutScreenSpec;
use App\ServiceInterface\Interfacing\Layout\LayoutGuardInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class LayoutGuard implements LayoutGuardInterface
{
    public function __construct(private readonly AuthorizationCheckerInterface $checker)
    {
    }

    public function canView(LayoutScreenSpec $spec, ?TokenInterface $token): bool
    {
        $guardKey = $spec->guardKey();
        if (null === $guardKey) {
            return true;
        }

        return $this->checker->isGranted($guardKey);
    }
}
