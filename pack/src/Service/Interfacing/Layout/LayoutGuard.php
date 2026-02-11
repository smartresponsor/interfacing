<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Service\Interfacing\Layout;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutGuardInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 *
 */

/**
 *
 */
final readonly class LayoutGuard implements LayoutGuardInterface
{
    /**
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
    ) {
    }

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface $spec
     * @return bool
     */
    public function canView(LayoutScreenSpecInterface $spec): bool
    {
        $guardKey = $spec->getGuardKey();
        if ($guardKey === null || $guardKey === '') {
            return true;
        }
        return $this->authorizationChecker->isGranted($guardKey);
    }
}
