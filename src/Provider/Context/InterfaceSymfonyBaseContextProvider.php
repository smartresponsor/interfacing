<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Context;

use App\Interfacing\ProviderInterface\Context\InterfaceRequestBaseContextProviderInterface;
use App\Interfacing\ResolverInterface\Tenant\InterfaceTenantResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final readonly class InterfaceSymfonyBaseContextProvider implements InterfaceRequestBaseContextProviderInterface
{
    public function __construct(
        private InterfaceTenantResolverInterface $tenantResolver,
        private RequestStack $requestStack,
        private ?TokenStorageInterface $tokenStorage = null,
    ) {
    }

    /**
     * @return array|mixed[]
     */
    public function provide(?Request $request = null, ?TokenInterface $token = null): array
    {
        $request ??= $this->requestStack->getCurrentRequest();
        if (null === $request) {
            return [
                'tenantId' => null,
                'userId' => null,
                'requestId' => '',
                'path' => '',
            ];
        }

        $token ??= $this->tokenStorage?->getToken();
        $tenantId = $this->tenantResolver->resolveTenantId($request, $token);

        $userId = null;
        if (null !== $token) {
            $user = $token->getUser();
            if (is_object($user) && method_exists($user, 'getUserIdentifier')) {
                $userId = (string) $user->getUserIdentifier();
            } elseif (is_string($user)) {
                $userId = $user;
            }
        }

        return [
            'tenantId' => $tenantId,
            'userId' => $userId,
            'requestId' => (string) $request->headers->get('X-Request-Id', ''),
            'path' => $request->getPathInfo(),
        ];
    }
}
