Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\Tests\Interfacing\Query;

use App\Domain\Interfacing\Query\OrderSummaryPage;
use App\Domain\Interfacing\Query\OrderSummaryRow;
use PHPUnit\Framework\TestCase;

final class OrderSummaryPageTest extends TestCase
{
    public function testCreatePage(): void
    {
        $row = new OrderSummaryRow('ord_1', 'paid', '2025-01-01T10:00:00Z', 199.99, 'USD', 'buyer@example.com');
        $page = new OrderSummaryPage([$row], 1, 1, 25);

        self::assertSame(1, $page->total);
        self::assertSame(1, $page->page);
        self::assertSame(25, $page->pageSize);
        self::assertCount(1, $page->items);
        self::assertSame('ord_1', $page->items[0]->id);
    }
}
