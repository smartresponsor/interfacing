<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Test\Service;

use PHPUnit\Framework\TestCase;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Context\BaseContextProviderInterface;
use SmartResponsor\Interfacing\Service\Interfacing\Context\BaseContextAssembler;

final class BaseContextAssemblerTest extends TestCase
{
    public function testItMergesProviderData(): void
    {
        $a = new class implements BaseContextProviderInterface {
            public function provide(): array { return ['tenantId' => 't1', 'x' => 1]; }
        };
        $b = new class implements BaseContextProviderInterface {
            public function provide(): array { return ['userId' => 'u1', 'x' => 2]; }
        };

        $asm = new BaseContextAssembler([$a, $b]);
        $ctx = $asm->assemble();

        self::assertSame('t1', $ctx['tenantId']);
        self::assertSame('u1', $ctx['userId']);
        self::assertSame(2, $ctx['x']);
    }
}
