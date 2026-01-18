<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\Service\Interfacing\Access;

use SmartResponsor\Interfacing\Domain\Interfacing\Access\AccessDecision;
use SmartResponsor\Interfacing\Domain\Interfacing\Runtime\InterfacingPermission;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Access\AccessResolverInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Security\PermissionNamerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class SymfonyAccessResolver implements AccessResolverInterface
{
    public function __construct(
        private readonly AuthorizationCheckerInterface $auth,
        private readonly PermissionNamerInterface $permission,
    ) {}

    public function canOpenScreen(string $screenId, Request $request, ?TokenInterface $token): AccessDecision
    {
        $attribute = $this->permission->screen($screenId);

        if ($this->auth->isGranted(InterfacingPermission::RoleAdmin)) {
            return AccessDecision::allow('admin');
        }

        if ($this->auth->isGranted($attribute)) {
            return AccessDecision::allow('granted');
        }

        return AccessDecision::deny('screen denied: ' . $attribute);
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

        return AccessDecision::deny('action denied: ' . $attribute);
    }
}
