<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\GuardInterface\Layout;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

interface InterfaceLayoutGuardInterface
{
    public function canView(InterfaceLayoutScreenSpec $spec, ?TokenInterface $token): bool;
}
