<?php

declare(strict_types=1);

namespace App\Interfacing\Resolver\Access;

use App\Interfacing\Contract\Access\InterfaceAccessDecision;
use App\Interfacing\Contract\Security\InterfacePermission;
use App\Interfacing\NamerInterface\Security\InterfacePermissionNamerInterface;
use App\Interfacing\ResolverInterface\Access\InterfaceScreenActionAccessResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Symfony-backed request-aware access resolver for Interfacing screens and actions.
 */
class InterfaceSymfonyScreenActionAccessResolver implements InterfaceScreenActionAccessResolverInterface
{
    /** @var list<string> */
    private const PUBLIC_SCREEN_IDS = [
        'billing-meter',
        'order-summary',
    ];

    public function __construct(
        private readonly InterfacePermissionNamerInterface $permission,
        private readonly ?AuthorizationCheckerInterface $auth = null,
    ) {
    }

    public function canOpenScreen(string $screenId, Request $request, ?TokenInterface $token): InterfaceAccessDecision
    {
        if (in_array($screenId, self::PUBLIC_SCREEN_IDS, true)) {
            return InterfaceAccessDecision::allow('public');
        }

        $attribute = $this->permission->screen($screenId);

        if ($this->auth?->isGranted(InterfacePermission::RoleAdmin) ?? false) {
            return InterfaceAccessDecision::allow('admin');
        }

        if ($this->auth?->isGranted($attribute) ?? false) {
            return InterfaceAccessDecision::allow('granted');
        }

        return InterfaceAccessDecision::deny('screen denied: '.$attribute);
    }

    public function canRunAction(string $screenId, string $actionId, Request $request, ?TokenInterface $token): InterfaceAccessDecision
    {
        $attribute = $this->permission->action($screenId, $actionId);

        if ($this->auth?->isGranted(InterfacePermission::RoleAdmin) ?? false) {
            return InterfaceAccessDecision::allow('admin');
        }

        if ($this->auth?->isGranted($attribute) ?? false) {
            return InterfaceAccessDecision::allow('granted');
        }

        return InterfaceAccessDecision::deny('action denied: '.$attribute);
    }
}
