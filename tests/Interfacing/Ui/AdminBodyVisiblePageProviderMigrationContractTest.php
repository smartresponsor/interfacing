<?php

declare(strict_types=1);

namespace App\Tests\Interfacing\Ui;

use App\Contract\Ui\AdminBodyVisiblePageProviderMigrationContract;
use PHPUnit\Framework\TestCase;

final class AdminBodyVisiblePageProviderMigrationContractTest extends TestCase
{
    public function testVisibleProviderPageContractIsStable(): void
    {
        self::assertSame('interfacing/admin/body/provider_page.html.twig', AdminBodyVisiblePageProviderMigrationContract::PROVIDER_PAGE_TEMPLATE);
        self::assertSame('interfacing/admin/body/mount.html.twig', AdminBodyVisiblePageProviderMigrationContract::MOUNT_TEMPLATE);
        self::assertContains('template/interfacing/page/*.twig', AdminBodyVisiblePageProviderMigrationContract::VISIBLE_PAGE_GLOBS);
        self::assertContains('<table', AdminBodyVisiblePageProviderMigrationContract::FORBIDDEN_VISIBLE_PAGE_PATTERNS);
    }
}
