<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Ui;

use App\Interfacing\Contract\Ui\AdminBodyConsumerProviderAdoptionRunnerContract;
use PHPUnit\Framework\TestCase;

final class AdminBodyConsumerProviderAdoptionRunnerContractTest extends TestCase
{
    public function testConsumerProviderAdoptionRunnerFilesAndMarkersArePresent(): void
    {
        $root = dirname(__DIR__, 3);

        foreach (AdminBodyConsumerProviderAdoptionRunnerContract::requiredFiles() as $relativePath) {
            self::assertFileExists($root.'/'.$relativePath, $relativePath);
        }

        $runner = file_get_contents($root.'/'.AdminBodyConsumerProviderAdoptionRunnerContract::RUNNER_ENTRYPOINT);
        self::assertIsString($runner);
        self::assertStringContainsString('--consumer-root=', $runner);
        self::assertStringContainsString('--defaults', $runner);
        self::assertStringContainsString('../Cruding', $runner);
        self::assertStringContainsString('admin-body-consumer-provider-adoption-audit.php', $runner);
        self::assertStringContainsString('Interfacing visible page provider adoption runner: OK', $runner);

        $doc = file_get_contents($root.'/'.AdminBodyConsumerProviderAdoptionRunnerContract::RUNNER_DOC);
        self::assertIsString($doc);
        self::assertStringContainsString('HostHub/App, Cruding, and Vendoring', $doc);
        self::assertStringContainsString('Ant Design ProComponents is the primary admin/workbench provider', $doc);
        self::assertStringContainsString('Twig is not an admin design system', $doc);
        self::assertStringContainsString('--require-existing', $doc);
    }
}
