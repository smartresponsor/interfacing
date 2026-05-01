<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Service;

use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceComponentRoadmapProvider;
use PHPUnit\Framework\TestCase;

final class EcommerceComponentRoadmapProviderTest extends TestCase
{
    public function testItProvidesFullKnownComponentRoadmap(): void
    {
        $provider = new EcommerceComponentRoadmapProvider();
        $items = $provider->provide();

        self::assertGreaterThanOrEqual(30, count($items));
        self::assertArrayHasKey('Catalog and discovery', $provider->groupedByZone());
        self::assertArrayHasKey('Platform operations', $provider->groupedByZone());

        $components = array_map(static fn ($item): string => $item->component(), $items);
        self::assertContains('Cataloging', $components);
        self::assertContains('Documenting', $components);
        self::assertContains('Harvesting', $components);
        self::assertContains('Bridging', $components);
    }

    public function testItCountsStatuses(): void
    {
        $counts = (new EcommerceComponentRoadmapProvider())->statusCounts();

        self::assertGreaterThan(0, $counts['connected']);
        self::assertGreaterThan(0, $counts['canonical']);
        self::assertGreaterThan(0, $counts['planned']);
        self::assertSame($counts['connected'] + $counts['canonical'] + $counts['planned'], $counts['total']);
    }
}
