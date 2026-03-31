<?php

declare(strict_types=1);

namespace App\Tests\Interfacing\Security;

use App\Contract\ValueObject\LayoutSlot;
use App\Contract\ValueObject\ScreenId;
use App\Contract\View\LayoutScreenSpecInterface;
use App\Service\Interfacing\View\ScreenViewBuilder;
use App\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use App\ServiceInterface\Interfacing\Shell\AccessResolverInterface;
use PHPUnit\Framework\TestCase;

final class ScreenViewBuilderOptionalCapabilityTest extends TestCase
{
    public function testBuildSkipsAccessCheckWhenCapabilityIsNull(): void
    {
        $spec = new class() implements LayoutScreenSpecInterface {
            public function block(): array
            {
                return [];
            }

            public function id(): string
            {
                return 'no-capability-layout';
            }

            public function title(): string
            {
                return 'No capability title';
            }

            public function navGroup(): string
            {
                return 'default';
            }

            public function screenId(): ScreenId
            {
                return ScreenId::fromString('demo.screen');
            }

            public function guardKey(): ?string
            {
                return null;
            }

            public function routePath(): ?string
            {
                return null;
            }

            public function navOrder(): int
            {
                return 0;
            }

            public function capability(): ?string
            {
                return null;
            }
        };

        $accessResolver = new class() implements AccessResolverInterface {
            public int $callCount = 0;

            public function allow(string $capability, array $context = []): bool
            {
                $this->callCount++;
                unset($capability, $context);

                return false;
            }
        };

        $builder = new ScreenViewBuilder(
            new class($spec) implements LayoutCatalogInterface {
                public function __construct(private LayoutScreenSpecInterface $spec)
                {
                }

                public function all(): array
                {
                    return [$this->spec->id() => $this->spec];
                }

                public function get(string $layoutKey): LayoutScreenSpecInterface
                {
                    if ($layoutKey !== $this->spec->id()) {
                        throw new \InvalidArgumentException('Unknown layout: '.$layoutKey);
                    }

                    return $this->spec;
                }

                public function find(string $layoutKey): ?LayoutScreenSpecInterface
                {
                    return $layoutKey === $this->spec->id() ? $this->spec : null;
                }
            },
            new class() implements ScreenRegistryInterface {
                public function has(ScreenId $id): bool
                {
                    unset($id);

                    return true;
                }

                public function componentName(ScreenId $id): string
                {
                    unset($id);

                    return 'interfacing_screen_demo';
                }
            },
            new class() implements ScreenContextAssemblerInterface {
                public function contextFor(LayoutScreenSpecInterface $spec): array
                {
                    unset($spec);

                    return ['mode' => 'optional-capability'];
                }
            },
            $accessResolver,
        );

        $out = $builder->build('no-capability-layout');

        self::assertSame(0, $accessResolver->callCount);
        self::assertSame('interfacing_screen_demo', $out['component']);
        self::assertSame(['mode' => 'optional-capability'], $out['context']);
        self::assertSame('No capability title', $out['title']);
        self::assertSame([
            'version' => 1,
            'slot' => LayoutSlot::all(),
        ], $out['layoutContract']);
    }
}
