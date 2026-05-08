<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Ui;

use App\Interfacing\Contract\Ui\AdminBodyBridgeProviderSurfaceContract;
use PHPUnit\Framework\TestCase;

final class AdminBodyBridgeProviderSurfaceContractTest extends TestCase
{
    public function testBridgeProviderSurfaceContractNamesCanonicalOwners(): void
    {
        self::assertSame('bridge', AdminBodyBridgeProviderSurfaceContract::INTEGRATION_OWNER);
        self::assertSame('interfacing', AdminBodyBridgeProviderSurfaceContract::RENDERING_OWNER);
        self::assertSame('antd-pro', AdminBodyBridgeProviderSurfaceContract::PRIMARY_PROVIDER);
        self::assertSame('primereact', AdminBodyBridgeProviderSurfaceContract::SECONDARY_PROVIDER);
        self::assertSame('bridging', AdminBodyBridgeProviderSurfaceContract::VISIBLE_ROUTE_ADOPTION_OWNER);
        self::assertSame('config/component/routes.yaml', AdminBodyBridgeProviderSurfaceContract::BRIDGING_ROUTE_CONFIG);
    }

    public function testBridgeProviderSurfaceIncludesCoreEcommerceSurfaces(): void
    {
        self::assertContains('catalog', AdminBodyBridgeProviderSurfaceContract::CANONICAL_ECOMMERCE_SURFACES);
        self::assertContains('crud', AdminBodyBridgeProviderSurfaceContract::CANONICAL_ECOMMERCE_SURFACES);
        self::assertContains('vendor', AdminBodyBridgeProviderSurfaceContract::CANONICAL_ECOMMERCE_SURFACES);
        self::assertContains('vendoring', AdminBodyBridgeProviderSurfaceContract::CANONICAL_ECOMMERCE_SURFACES);
    }
}
