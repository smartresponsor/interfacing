Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\Tests\Interfacing\Query;

use App\Domain\Interfacing\Query\BillingMeterPage;
use App\Domain\Interfacing\Query\BillingMeterRow;
use PHPUnit\Framework\TestCase;

final class BillingMeterPageTest extends TestCase
{
    public function testCreatePage(): void
    {
        $row = new BillingMeterRow('mtr_1', 'active', 10.5, '2025-01-01', '2025-01-31');
        $page = new BillingMeterPage([$row], 1, 1, 25);

        self::assertSame(1, $page->total);
        self::assertSame(1, $page->page);
        self::assertSame(25, $page->pageSize);
        self::assertCount(1, $page->items);
        self::assertSame('mtr_1', $page->items[0]->id);
    }
}
