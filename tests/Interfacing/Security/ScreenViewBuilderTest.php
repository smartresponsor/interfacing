<?php

declare(strict_types=1);

namespace App\Tests\Interfacing\Security;

use App\Contract\Error\ScreenForbidden;
use App\Contract\Error\ScreenNotFound;
use App\Contract\ValueObject\LayoutSlot;
use App\Contract\ValueObject\ScreenId;
use App\Contract\View\LayoutScreenSpecInterface;
use App\Service\Interfacing\View\ScreenViewBuilder;
use App\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use App\ServiceInterface\Interfacing\Shell\AccessResolverInterface;
use PHPUnit\Framework\TestCase;

final class ScreenViewBuilderTest extends TestCase
{
    public function testBuildReturnsExpectedPayloadForAccessibleScreen(): void
    {
        $spec = $this->spec('demo-layout', 'Demo title', 'demo.screen', 'cap.view.demo');

        $builder = new ScreenViewBuilder(
            $this->catalog($spec),
            $this->screenRegistry('interfacing_screen_demo'),
            $this->contextAssembler(['tenant' => 't-1', 'mode' => 'demo']),
            $this->accessResolver(true),
        );

        $out = $builder->build('demo-layout');

        self::assertSame($spec, $out['spec']);
        self::assertSame('interfacing_screen_demo', $out['component']);
        self::assertSame(['tenant' => 't-1', 'mode' => 'demo'], $out['context']);
        self::assertSame('Demo title', $out['title']);
        self::assertSame([
            'version' => 1,
            'slot' => LayoutSlot::all(),
        ], $out['layoutContract']);
    }

    public function testBuildThrowsNotFoundWhenLayoutDoesNotExist(): void
    {
        $builder = new ScreenViewBuilder(
            $this->catalog(null),
            $this->screenRegistry('unused'),
            $this->contextAssembler([]),
            $this->accessResolver(true),
        );

        $this->expectException(ScreenNotFound::class);
        $this->expectExceptionMessage('Unknown interfacing screen: missing-layout');

        $builder->build('missing-layout');
    }

    public function testBuildThrowsForbiddenWhenAccessResolverDeniesCapability(): void
    {
        $spec = $this->spec('forbidden-layout', 'Forbidden title', 'demo.screen', 'cap.view.denied');

        $builder = new ScreenViewBuilder(
            $this->catalog($spec),
            $this->screenRegistry('interfacing_screen_demo'),
            $this->contextAssembler(['tenant' => 't-1']),
            $this->accessResolver(false),
        );

        $this->expectException(ScreenForbidden::class);
        $this->expectExceptionMessage('Access denied for screen: forbidden-layout');

        $builder->build('forbidden-layout');
    }

    private function catalog(?LayoutScreenSpecInterface $spec): LayoutCatalogInterface
    {
        return new class($spec) implements LayoutCatalogInterface {
            public function __construct(private ?LayoutScreenSpecInterface $spec)
            {
            }

            public function all(): array
            {
                return null === $this->spec ? [] : [$this->spec->id() => $this->spec];
            }

            public function get(string $layoutKey): LayoutScreenSpecInterface
            {
                if (null === $this->spec || $layoutKey !== $this->spec->id()) {
                    throw new \InvalidArgumentException('Unknown layout: '.$layoutKey);
                }

                return $this->spec;
            }

            public function find(string $layoutKey): ?LayoutScreenSpecInterface
            {
                if (null === $this->spec || $layoutKey !== $this->spec->id()) {
                    return null;
                }

                return $this->spec;
            }
        };
    }

    private function screenRegistry(string $componentName): ScreenRegistryInterface
    {
        return new class($componentName) implements ScreenRegistryInterface {
            public function __construct(private string $componentName)
            {
            }

            public function has(ScreenId $id): bool
            {
                unset($id);

                return true;
            }

            public function componentName(ScreenId $id): string
            {
                unset($id);

                return $this->componentName;
            }
        };
    }

    private function contextAssembler(array $context): ScreenContextAssemblerInterface
    {
        return new class($context) implements ScreenContextAssemblerInterface {
            public function __construct(private array $context)
            {
            }

            public function contextFor(LayoutScreenSpecInterface $spec): array
            {
                unset($spec);

                return $this->context;
            }
        };
    }

    private function accessResolver(bool $allow): AccessResolverInterface
    {
        return new class($allow) implements AccessResolverInterface {
            public function __construct(private bool $allow)
            {
            }

            public function allow(string $capability, array $context = []): bool
            {
                unset($capability, $context);

                return $this->allow;
            }
        };
    }

    private function spec(string $id, string $title, string $screenId, ?string $capability): LayoutScreenSpecInterface
    {
        return new class($id, $title, $screenId, $capability) implements LayoutScreenSpecInterface {
            private ScreenId $screenIdObject;

            public function __construct(
                private string $id,
                private string $title,
                string $screenId,
                private ?string $capability,
            ) {
                $this->screenIdObject = ScreenId::fromString($screenId);
            }

            public function block(): array
            {
                return [];
            }

            public function id(): string
            {
                return $this->id;
            }

            public function title(): string
            {
                return $this->title;
            }

            public function navGroup(): string
            {
                return 'default';
            }

            public function screenId(): ScreenId
            {
                return $this->screenIdObject;
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
                return $this->capability;
            }
        };
    }
}
