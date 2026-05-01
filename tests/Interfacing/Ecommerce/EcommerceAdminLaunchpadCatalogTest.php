<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Ecommerce;

use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceScreenCatalogProvider;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceExplorerProviderInterface;
use PHPUnit\Framework\TestCase;

final class EcommerceAdminLaunchpadCatalogTest extends TestCase
{
    public function testPlatformCatalogContainsAdminLaunchpad(): void
    {
        $provider = new EcommerceScreenCatalogProvider(new class implements CrudResourceExplorerProviderInterface {
            public function provide(): array
            {
                return [];
            }
        });

        $ids = array_map(static fn ($entry): string => $entry->id(), $provider->provide());

        self::assertContains('platform.admin-launchpad', $ids);
        self::assertArrayHasKey('Platform', $provider->groupedByZone());
    }
}
