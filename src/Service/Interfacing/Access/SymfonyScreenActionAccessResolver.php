<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Access;

use App\Interfacing\Application\Security\InterfacingPermission;
use App\Interfacing\Contract\Access\AccessDecision;
use App\Interfacing\ServiceInterface\Interfacing\Access\ScreenActionAccessResolverInterface;
use App\Interfacing\ServiceInterface\Interfacing\Security\PermissionNamerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Symfony-backed request-aware access resolver for Interfacing screens and actions.
 */
class SymfonyScreenActionAccessResolver implements ScreenActionAccessResolverInterface
{
    /** @var list<string> */
    private const PUBLIC_SCREEN_IDS = [
        'billing-meter',
        'order-summary',
    ];

    public function __construct(
        private readonly PermissionNamerInterface $permission,
        private readonly ?AuthorizationCheckerInterface $auth = null,
    ) {
    }

    public function canOpenScreen(string $screenId, Request $request, ?TokenInterface $token): AccessDecision
    {
        if (in_array($screenId, self::PUBLIC_SCREEN_IDS, true)) {
            return AccessDecision::allow('public');
        }

        $attribute = $this->permission->screen($screenId);

        if ($this->auth?->isGranted(InterfacingPermission::RoleAdmin) ?? false) {
            return AccessDecision::allow('admin');
        }

        if ($this->auth?->isGranted($attribute) ?? false) {
            return AccessDecision::allow('granted');
        }

        return AccessDecision::deny('screen denied: '.$attribute);
    }

    public function canRunAction(string $screenId, string $actionId, Request $request, ?TokenInterface $token): AccessDecision
    {
        $attribute = $this->permission->action($screenId, $actionId);

        if ($this->auth?->isGranted(InterfacingPermission::RoleAdmin) ?? false) {
            return AccessDecision::allow('admin');
        }

        if ($this->auth?->isGranted($attribute) ?? false) {
            return AccessDecision::allow('granted');
        }

        return AccessDecision::deny('action denied: '.$attribute);
    }
}
