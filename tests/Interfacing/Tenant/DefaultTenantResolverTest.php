<?php
declare(strict_types=1);

namespace App\Tests\Interfacing\Tenant;

use App\Service\Interfacing\Tenant\DefaultTenantResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class DefaultTenantResolverTest extends TestCase
{
    public function testResolveFromHeader(): void
    {
        $r = new Request();
        $r->headers->set(DefaultTenantResolver::HeaderTenant, 'demo');
        $resolver = new DefaultTenantResolver('default');

        self::assertSame('demo', $resolver->resolveTenantId($r, null));
    }

    public function testResolveFromAttribute(): void
    {
        $r = new Request();
        $r->attributes->set('tenantId', 't1');
        $resolver = new DefaultTenantResolver('default');

        self::assertSame('t1', $resolver->resolveTenantId($r, null));
    }

    public function testResolveDefault(): void
    {
        $r = new Request();
        $resolver = new DefaultTenantResolver('default');

        self::assertSame('default', $resolver->resolveTenantId($r, null));
    }
}
