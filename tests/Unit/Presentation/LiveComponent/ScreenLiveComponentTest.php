<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Unit\Presentation\LiveComponent;

use App\Interfacing\Contract\View\ScreenSpecInterface;
use App\Interfacing\Presentation\LiveComponent\Interfacing\ScreenLiveComponent;
use App\Interfacing\ServiceInterface\Interfacing\Action\ActionDispatcherInterface;
use App\Interfacing\ServiceInterface\Interfacing\Registry\ScreenRegistryInterface;
use PHPUnit\Framework\TestCase;

final class ScreenLiveComponentTest extends TestCase
{
    public function testMountUsesContextScreenIdInsteadOfDemoDefault(): void
    {
        $screenSpec = $this->createMock(ScreenSpecInterface::class);
        $screenSpec->method('defaultState')->willReturn([]);

        $screenRegistry = $this->createMock(ScreenRegistryInterface::class);
        $screenRegistry->expects(self::once())
            ->method('get')
            ->with('message.notifications.inbox')
            ->willReturn($screenSpec);

        $actionDispatcher = $this->createMock(ActionDispatcherInterface::class);

        $component = new ScreenLiveComponent($screenRegistry, $actionDispatcher);

        $component->mount('message.notifications.inbox', ['screenId' => 'message.notifications.inbox']);

        self::assertSame('message.notifications.inbox', $component->screenId);
        self::assertSame(['screenId' => 'message.notifications.inbox'], $component->context);
    }
}
