<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Service;

use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceComponentObligationProvider;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceComponentRoadmapProvider;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceContractRegistryProvider;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceEvidenceRegistryProvider;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceFieldSchemaRegistryProvider;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommercePromotionGateProvider;
use App\Interfacing\Service\Interfacing\Ecommerce\EcommerceRuntimeBridgeProvider;
use PHPUnit\Framework\TestCase;

final class EcommerceFieldSchemaRegistryProviderTest extends TestCase
{
    public function testItDerivesFieldSchemaRowsFromContractRegistry(): void
    {
        $roadmap = new EcommerceComponentRoadmapProvider();
        $obligations = new EcommerceComponentObligationProvider($roadmap);
        $bridges = new EcommerceRuntimeBridgeProvider($obligations);
        $promotions = new EcommercePromotionGateProvider($bridges);
        $evidence = new EcommerceEvidenceRegistryProvider($promotions);
        $contracts = new EcommerceContractRegistryProvider($evidence);
        $provider = new EcommerceFieldSchemaRegistryProvider($contracts);

        $items = $provider->provide();

        self::assertNotEmpty($items);
        self::assertArrayHasKey('total', $provider->gradeCounts());
        self::assertGreaterThan(0, $provider->gradeCounts()['total']);
        self::assertNotEmpty($items[0]->identifierContracts());
        self::assertNotEmpty($items[0]->tableColumns());
        self::assertNotEmpty($items[0]->formFields());
        self::assertNotEmpty($items[0]->validationRules());
        self::assertNotEmpty($items[0]->relationshipFields());
    }
}
