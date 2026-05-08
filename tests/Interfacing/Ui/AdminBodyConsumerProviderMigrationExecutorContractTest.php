<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp.
 */

namespace App\Tests\Interfacing\Ui;

use App\Contract\Ui\AdminBodyConsumerProviderMigrationExecutorContract;
use PHPUnit\Framework\TestCase;

final class AdminBodyConsumerProviderMigrationExecutorContractTest extends TestCase
{
    public function testConsumerProviderMigrationExecutorContractIsComplete(): void
    {
        self::assertSame(
            'interfacing/admin/body/provider_page.html.twig',
            AdminBodyConsumerProviderMigrationExecutorContract::PROVIDER_PAGE_TEMPLATE
        );
        self::assertSame('antd-pro', AdminBodyConsumerProviderMigrationExecutorContract::PRIMARY_PROVIDER);
        self::assertSame('primereact', AdminBodyConsumerProviderMigrationExecutorContract::SECONDARY_PROVIDER);

        self::assertContains(
            '../Cataloging',
            AdminBodyConsumerProviderMigrationExecutorContract::DEFAULT_CONSUMER_ROOTS
        );
        self::assertArrayHasKey(
            'Cataloging',
            AdminBodyConsumerProviderMigrationExecutorContract::KNOWN_VISIBLE_TEMPLATE_TARGETS
        );
        self::assertContains(
            'templates/category/list.html.twig',
            AdminBodyConsumerProviderMigrationExecutorContract::KNOWN_VISIBLE_TEMPLATE_TARGETS['Cataloging']
        );
        self::assertContains(
            '<style',
            AdminBodyConsumerProviderMigrationExecutorContract::FORBIDDEN_PRIMARY_UI_MARKERS
        );
    }
}
