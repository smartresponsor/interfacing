<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Service\Interfacing\Security;

    use App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;
use App\ServiceInterface\Interfacing\Security\AccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

    /**
     *
     */

    /**
     *
     */
    final readonly class SymfonyAccessResolver implements AccessResolverInterface
{
    /**
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
    ) {}

    /**
     * @param \App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface $screen
     * @return bool
     */
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

