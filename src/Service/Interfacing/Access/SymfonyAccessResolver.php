Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\Service\Interfacing\Access;

use App\Domain\Interfacing\Access\AccessDecision;
use App\Domain\Interfacing\Runtime\InterfacingPermission;
use App\DomainInterface\Interfacing\Access\AccessResolverInterface;
use App\DomainInterface\Interfacing\Security\PermissionNamerInterface;
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
