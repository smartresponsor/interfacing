<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\AccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class SymfonyAccessResolver implements AccessResolverInterface
{
    public function __construct(private readonly ?AuthorizationCheckerInterface $checker = null)
    {
    }

    public function canAccess(array $requireRole): bool
    {
        foreach ($requireRole as $role) {
            if (!$this->checker->isGranted($role)) {
                return false;
            }
        }

        return true;
    }
}
