<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Service\Interfacing\Layout;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Layout\LayoutScreenSpec;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutGuardInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class LayoutGuard implements LayoutGuardInterface
{
    public function __construct(private AuthorizationCheckerInterface $checker)
    {
    }

    public function canView(LayoutScreenSpec $spec, ?TokenInterface $token): bool
    {
        $guardKey = $spec->guardKey();
        if ($guardKey === null) {
            return true;
        }

        return $this->checker->isGranted($guardKey);
    }
}
