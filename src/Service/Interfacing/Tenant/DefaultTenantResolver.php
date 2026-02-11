<?php
declare(strict_types=1);

namespace App\Service\Interfacing\Tenant;

use App\DomainInterface\Interfacing\Tenant\TenantResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class DefaultTenantResolver implements TenantResolverInterface
{
    public const HeaderTenant = 'X-SR-Tenant';

    public function __construct(
        private readonly string $defaultTenantId = 'default',
    ) {}

    public function resolveTenantId(Request $request, ?TokenInterface $token): string
    {
        $header = trim((string) $request->headers->get(self::HeaderTenant, ''));
        if ($header !== '') {
            return $header;
        }

        $attr = trim((string) $request->attributes->get('tenantId', ''));
        if ($attr !== '') {
            return $attr;
        }

        return $this->defaultTenantId;
    }
}
