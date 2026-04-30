<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Access;

use App\Interfacing\Application\Security\InterfacingPermission;
use App\Interfacing\Contract\Access\AccessDecision;
use App\Interfacing\ServiceInterface\Interfacing\Access\AccessResolverInterface;
use App\Interfacing\ServiceInterface\Interfacing\Security\PermissionNamerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final readonly class SymfonyAccessResolver implements AccessResolverInterface
{
    public function __construct(
        private ?AuthorizationCheckerInterface $auth = null,
        private PermissionNamerInterface $permission,
    ) {
    }

    public function canOpenScreen(string $screenId, Request $request, ?TokenInterface $token): AccessDecision
    {
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
