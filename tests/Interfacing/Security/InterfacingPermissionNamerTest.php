<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Security;

use App\Interfacing\Service\Interfacing\Security\InterfacingPermissionNamer;
use PHPUnit\Framework\TestCase;

/**
 *
 */

/**
 *
 */
final class InterfacingPermissionNamerTest extends TestCase
{
    /**
     * @return void
     */
    public function testScreenPermission(): void
    {
        $namer = new InterfacingPermissionNamer();
        self::assertSame('interfacing.screen.category-admin', $namer->screen('Category Admin'));
    }

    /**
     * @return void
     */
    public function testActionPermission(): void
    {
        $namer = new InterfacingPermissionNamer();
        self::assertSame('interfacing.action.order-drill.refund', $namer->action('order-drill', 'refund'));
    }
}
