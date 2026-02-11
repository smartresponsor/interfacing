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

/**
 *
 */

/**
 *
 */
final readonly class SymfonyAccessResolver implements AccessResolverInterface
{
    /**
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $auth
     * @param \App\DomainInterface\Interfacing\Security\PermissionNamerInterface $permission
     */
    public function __construct(
        private AuthorizationCheckerInterface $auth,
        private PermissionNamerInterface      $permission,
    ) {}

    /**
     * @param string $screenId
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface|null $token
     * @return \App\Domain\Interfacing\Access\AccessDecision
     */
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

    /**
     * @param string $screenId
     * @param string $actionId
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface|null $token
     * @return \App\Domain\Interfacing\Access\AccessDecision
     */
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
