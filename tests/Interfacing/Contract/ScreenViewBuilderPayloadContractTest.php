<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Contract;

use App\Interfacing\Contract\ValueObject\LayoutSlot;
use App\Interfacing\Contract\ValueObject\ScreenId;
use App\Interfacing\Contract\View\LayoutScreenSpecInterface;
use App\Interfacing\Service\Interfacing\View\ScreenViewBuilder;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\CapabilityAccessResolverInterface;
use PHPUnit\Framework\TestCase;

final class ScreenViewBuilderPayloadContractTest extends TestCase
{
    public function testBuildReturnsStablePayloadShape(): void
    {
        $spec = new class() implements LayoutScreenSpecInterface {
            public function block(): array
            {
                return [];
            }

            public function id(): string
            {
                return 'contract-layout';
            }

            public function title(): string
            {
                return 'Contract title';
            }

            public function navGroup(): string
            {
                return 'default';
            }

            public function screenId(): ScreenId
            {
                return ScreenId::fromString('contract.screen');
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
                return 10;
            }

            public function capability(): ?string
            {
                return 'cap.contract.view';
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

                    return 'interfacing_contract_screen';
                }
            },
            new class() implements ScreenContextAssemblerInterface {
                public function contextFor(LayoutScreenSpecInterface $spec): array
                {
                    unset($spec);

                    return [
                        'tenant' => 'tenant-1',
                        'mode' => 'contract',
                    ];
                }
            },
            new class() implements CapabilityAccessResolverInterface {
                public function allow(string $capability, array $context = []): bool
                {
                    TestCase::assertSame('cap.contract.view', $capability);
                    TestCase::assertSame([
                        'layoutId' => 'contract-layout',
                        'screenId' => 'contract.screen',
                    ], $context);

                    return true;
                }
            },
        );

        $payload = $builder->build('contract-layout');

        self::assertSame(
            ['spec', 'component', 'context', 'title', 'layoutContract'],
            array_keys($payload),
        );

        self::assertSame($spec, $payload['spec']);
        self::assertSame('interfacing_contract_screen', $payload['component']);
        self::assertSame([
            'tenant' => 'tenant-1',
            'mode' => 'contract',
        ], $payload['context']);
        self::assertSame('Contract title', $payload['title']);

        self::assertIsArray($payload['layoutContract']);
        self::assertSame(['version', 'slot'], array_keys($payload['layoutContract']));
        self::assertSame(1, $payload['layoutContract']['version']);
        self::assertSame(LayoutSlot::all(), $payload['layoutContract']['slot']);
    }
}
