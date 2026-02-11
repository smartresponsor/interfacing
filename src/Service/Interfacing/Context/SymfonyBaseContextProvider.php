<?php
declare(strict_types=1);

namespace App\Service\Interfacing\Context;

use App\DomainInterface\Interfacing\Context\BaseContextProviderInterface;
use App\DomainInterface\Interfacing\Tenant\TenantResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 *
 */

/**
 *
 */
final readonly class SymfonyBaseContextProvider implements BaseContextProviderInterface
{
    /**
     * @param \App\DomainInterface\Interfacing\Tenant\TenantResolverInterface $tenantResolver
     */
    public function __construct(
        private TenantResolverInterface $tenantResolver,
    ) {}

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface|null $token
     * @return array|mixed[]
     */
    public function provide(Request $request, ?TokenInterface $token): array
    {
        $tenantId = $this->tenantResolver->resolveTenantId($request, $token);

        $userId = null;
        if ($token !== null) {
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
