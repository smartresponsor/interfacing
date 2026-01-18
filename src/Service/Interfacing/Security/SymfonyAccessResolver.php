<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Service\Interfacing\Security;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Security\AccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class SymfonyAccessResolver implements AccessResolverInterface
{
    public function __construct(
        private readonly AuthorizationCheckerInterface $authorizationChecker,
    ) {}

    public function isAllowed(ScreenSpecInterface $screen): bool
    {
        $roles = $screen->requireRole();
        if ($roles === []) {
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

