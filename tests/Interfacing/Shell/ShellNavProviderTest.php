<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Shell;

use App\Interfacing\Contract\View\ShellNavGroup;
use App\Interfacing\Service\Interfacing\ShellNavProvider;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellChromeProviderInterface;
use PHPUnit\Framework\TestCase;

final class ShellNavProviderTest extends TestCase
{
    public function testProvideUsesChromePrimaryAndSectionGroups(): void
    {
        $chromeProvider = new class implements ShellChromeProviderInterface {
            public function provide(?string $activeId = null): array
            {
                return [
                    'primaryGroup' => [new ShellNavGroup('primary', 'Primary', [])],
                    'sectionGroup' => [new ShellNavGroup('section', 'Section', [])],
                ];
            }
        };

        $provider = new ShellNavProvider($chromeProvider);
        $groups = $provider->provide();

        self::assertCount(2, $groups);
        self::assertSame('primary', $groups[0]->id());
        self::assertSame('section', $groups[1]->id());
    }
}
