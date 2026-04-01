<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Access;

use App\Application\Security\InterfacingPermission;
use App\Contract\Access\AccessDecision;
use App\ServiceInterface\Interfacing\Access\AccessResolverInterface;
use App\ServiceInterface\Interfacing\Security\PermissionNamerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final readonly class SymfonyAccessResolver implements AccessResolverInterface
{
    public function __construct(
        private AuthorizationCheckerInterface $auth,
        private PermissionNamerInterface $permission,
    ) {
    }

    public function canOpenScreen(string $screenId, Request $request, ?TokenInterface $token): AccessDecision
    {
        $attribute = $this->permission->screen($screenId);

        if ($this->auth->isGranted(InterfacingPermission::RoleAdmin)) {
            return AccessDecision::allow('admin');
        }

        if ($this->auth->isGranted($attribute)) {
            return AccessDecision::allow('granted');
        }

        return AccessDecision::deny('screen denied: '.$attribute);
    }

    public function canRunAction(string $screenId, string $actionId, Request $request, ?TokenInterface $token): AccessDecision
    {
        $attribute = $this->permission->action($screenId, $actionId);

        if ($this->auth->isGranted(InterfacingPermission::RoleAdmin)) {
            return AccessDecision::allow('admin');
        }

        if ($this->auth->isGranted($attribute)) {
            return AccessDecision::allow('granted');
        }

        return AccessDecision::deny('action denied: '.$attribute);
    }
}
