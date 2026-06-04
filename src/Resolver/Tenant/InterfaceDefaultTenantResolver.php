<?php

declare(strict_types=1);

namespace App\Interfacing\Resolver\Tenant;

use App\Interfacing\ResolverInterface\Tenant\InterfaceTenantResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class InterfaceDefaultTenantResolver implements InterfaceTenantResolverInterface
{
    public const HeaderTenant = 'X-interfacing-Tenant';

    public function __construct(
        private readonly string $defaultTenantId = 'default',
    ) {
    }

    public function resolveTenantId(Request $request, ?TokenInterface $token): string
    {
        $header = trim((string) $request->headers->get(self::HeaderTenant, ''));
        if ('' !== $header) {
            return $header;
        }

        $attr = trim((string) $request->attributes->get('tenantId', ''));
        if ('' !== $attr) {
            return $attr;
        }

        return $this->defaultTenantId;
    }
}
