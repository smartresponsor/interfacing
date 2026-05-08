<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Ui;

use App\Interfacing\Contract\Ui\AdminBodyConsumerProviderAdoptionContract;
use PHPUnit\Framework\TestCase;

final class AdminBodyConsumerProviderAdoptionContractTest extends TestCase
{
    public function testConsumerProviderAdoptionContractFilesAndMarkersArePresent(): void
    {
        $root = dirname(__DIR__, 3);

        foreach (AdminBodyConsumerProviderAdoptionContract::requiredFiles() as $relativePath) {
            self::assertFileExists($root.'/'.$relativePath, $relativePath);
        }

        $tool = file_get_contents($root.'/'.AdminBodyConsumerProviderAdoptionContract::AUDIT_ENTRYPOINT);
        self::assertIsString($tool);
        self::assertStringContainsString('--consumer-root=', $tool);
        self::assertStringContainsString('missing Interfacing admin body provider mount', $tool);
        self::assertStringContainsString('Bootstrap-like', $tool);
        self::assertStringContainsString('handmade Twig table/form', $tool);

        $doc = file_get_contents($root.'/'.AdminBodyConsumerProviderAdoptionContract::CONTRACT_DOC);
        self::assertIsString($doc);
        self::assertStringContainsString('HostHub/App, Cruding, Vendoring', $doc);
        self::assertStringContainsString('Ant Design ProComponents primary', $doc);
        self::assertStringContainsString('PrimeReact secondary', $doc);
        self::assertStringContainsString('must not be treated as the admin design system', $doc);
    }
}
