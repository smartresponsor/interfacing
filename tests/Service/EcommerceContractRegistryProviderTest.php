<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Service;

use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceComponentObligationProvider;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceComponentRoadmapProvider;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceContractRegistryProvider;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceEvidenceRegistryProvider;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommercePromotionGateProvider;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceRuntimeBridgeProvider;
use PHPUnit\Framework\TestCase;

final class EcommerceContractRegistryProviderTest extends TestCase
{
    public function testItDerivesContractRowsFromEvidenceRegistry(): void
    {
        $roadmap = new EcommerceComponentRoadmapProvider();
        $obligations = new EcommerceComponentObligationProvider($roadmap);
        $bridges = new EcommerceRuntimeBridgeProvider($obligations);
        $promotions = new EcommercePromotionGateProvider($bridges);
        $evidence = new EcommerceEvidenceRegistryProvider($promotions);
        $provider = new EcommerceContractRegistryProvider($evidence);

        $items = $provider->provide();

        self::assertNotEmpty($items);
        self::assertArrayHasKey('total', $provider->gradeCounts());
        self::assertGreaterThan(0, $provider->gradeCounts()['total']);
        self::assertNotEmpty($items[0]->screenContracts());
        self::assertNotEmpty($items[0]->dataContracts());
        self::assertNotEmpty($items[0]->operationContracts());
        self::assertNotEmpty($items[0]->policyContracts());
        self::assertNotEmpty($items[0]->evidenceContracts());
    }
}
