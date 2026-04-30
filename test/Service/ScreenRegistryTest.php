<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Interfacing\Test\Service;

use PHPUnit\Framework\TestCase;
use App\Interfacing\Domain\Interfacing\Screen\ScreenId;
use App\Interfacing\Domain\Interfacing\Screen\ScreenSpec;
use App\Interfacing\DomainInterface\Interfacing\Screen\ScreenProviderInterface;
use App\Interfacing\Service\Interfacing\Screen\ScreenRegistry;

/**
 *
 */

/**
 *
 */
final class ScreenRegistryTest extends TestCase
{
    /**
     * @return void
     */
    public function testItBuildsSortedMap(): void
    {
        $p = new class implements ScreenProviderInterface {
            /**
             * @return \App\Interfacing\Domain\Interfacing\Screen\ScreenSpec[]
             */
            public function provide(): array
            {
                return [
                    new ScreenSpec(new ScreenId('b-screen'), 'B', 'l1'),
                    new ScreenSpec(new ScreenId('a-screen'), 'A', 'l2'),
                ];
            }
        };

        $reg = new ScreenRegistry([$p]);
        $all = $reg->all();

        self::assertSame(['a-screen', 'b-screen'], array_keys($all));
        self::assertSame('A', $reg->get(new ScreenId('a-screen'))->title());
    }

    /**
     * @return void
     */
    public function testItRejectsDuplicate(): void
    {
        $p = new class implements ScreenProviderInterface {
            /**
             * @return \App\Interfacing\Domain\Interfacing\Screen\ScreenSpec[]
             */
            public function provide(): array
            {
                return [
                    new ScreenSpec(new ScreenId('dup'), 'A', 'l1'),
                    new ScreenSpec(new ScreenId('dup'), 'B', 'l2'),
                ];
            }
        };

        $reg = new ScreenRegistry([$p]);
        $this->expectException(\LogicException::class);
        $reg->all();
    }
}
