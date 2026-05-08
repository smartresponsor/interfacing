<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Ui;

use App\Interfacing\Contract\Ui\AdminBodyEcommerceUiCoverageContract;
use PHPUnit\Framework\TestCase;

final class AdminBodyEcommerceUiCoverageContractTest extends TestCase
{
    public function testCanonicalComponentsAndPageFamiliesAreDeclared(): void
    {
        self::assertContains('Cruding', AdminBodyEcommerceUiCoverageContract::canonicalComponents());
        self::assertContains('Cataloging', AdminBodyEcommerceUiCoverageContract::canonicalComponents());
        self::assertContains('Ordering', AdminBodyEcommerceUiCoverageContract::canonicalComponents());
        self::assertContains('Paying', AdminBodyEcommerceUiCoverageContract::canonicalComponents());
        self::assertContains('Shipping', AdminBodyEcommerceUiCoverageContract::canonicalComponents());
        self::assertContains('public-storefront', AdminBodyEcommerceUiCoverageContract::ecommercePageFamilies());
        self::assertContains('cart-checkout', AdminBodyEcommerceUiCoverageContract::ecommercePageFamilies());
    }

    public function testProviderOwnershipIsCanonical(): void
    {
        self::assertSame('antd-pro', AdminBodyEcommerceUiCoverageContract::PRIMARY_PROVIDER);
        self::assertSame('primereact', AdminBodyEcommerceUiCoverageContract::SECONDARY_PROVIDER);
    }
}
