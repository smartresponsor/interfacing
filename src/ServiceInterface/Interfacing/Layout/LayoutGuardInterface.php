<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Layout;

use App\Domain\Interfacing\Model\Layout\LayoutScreenSpec;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

interface LayoutGuardInterface
{
    public function canView(LayoutScreenSpec $spec, ?TokenInterface $token): bool;
}
