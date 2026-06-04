<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Guard\Layout;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\GuardInterface\Layout\InterfaceLayoutGuardInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class InterfaceLayoutGuard implements InterfaceLayoutGuardInterface
{
    public function __construct(private readonly ?AuthorizationCheckerInterface $checker = null)
    {
    }

    public function canView(InterfaceLayoutScreenSpec $spec, ?TokenInterface $token): bool
    {
        $guardKey = $spec->guardKey();
        if (null === $guardKey) {
            return true;
        }

        return $this->checker->isGranted($guardKey);
    }
}
