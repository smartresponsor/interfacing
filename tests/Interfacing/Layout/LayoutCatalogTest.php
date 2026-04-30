<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Layout;

use App\Interfacing\Contract\View\LayoutScreenSpecInterface;
use App\Interfacing\Contract\ValueObject\ScreenIdInterface;
use App\Interfacing\Service\Interfacing\Layout\LayoutCatalog;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutProviderInterface;
use PHPUnit\Framework\TestCase;

final class LayoutCatalogTest extends TestCase
{
    public function testListAliasesAll(): void
    {
        $spec = new class implements LayoutScreenSpecInterface {
            public function block(): array { return []; }
            public function id(): string { return 'demo'; }
            public function title(): string { return 'Demo'; }
            public function description(): string { return 'Demo description'; }
            public function navGroup(): string { return 'workspace'; }
            public function screenId(): ScreenIdInterface { return new class implements ScreenIdInterface {
                public function value(): string { return 'screen-demo'; }
                public function toString(): string { return 'screen-demo'; }
            }; }
            public function guardKey(): ?string { return null; }
            public function routePath(): ?string { return null; }
            public function navOrder(): int { return 10; }
            public function context(): array { return []; }
        };

        $provider = new class($spec) implements LayoutProviderInterface {
            public function __construct(private readonly LayoutScreenSpecInterface $spec) {}
            public function provide(): array { return [$this->spec]; }
        };

        $catalog = new LayoutCatalog([$provider]);

        self::assertSame($catalog->all(), $catalog->list());
        self::assertArrayHasKey('demo', $catalog->list());
        self::assertSame($spec, $catalog->find('demo'));
        self::assertNull($catalog->find('missing'));
    }
}
