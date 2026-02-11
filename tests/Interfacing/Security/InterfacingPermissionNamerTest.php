<?php
declare(strict_types=1);

namespace App\Tests\Interfacing\Security;

use App\Service\Interfacing\Security\InterfacingPermissionNamer;
use PHPUnit\Framework\TestCase;

final class InterfacingPermissionNamerTest extends TestCase
{
    public function testScreenPermission(): void
    {
        $namer = new InterfacingPermissionNamer();
        self::assertSame('interfacing.screen.category-admin', $namer->screen('Category Admin'));
    }

    public function testActionPermission(): void
    {
        $namer = new InterfacingPermissionNamer();
        self::assertSame('interfacing.action.order-drill.refund', $namer->action('order-drill', 'refund'));
    }
}
