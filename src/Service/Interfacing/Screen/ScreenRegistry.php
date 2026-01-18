<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Service\Interfacing\Screen;

use SmartResponsor\Interfacing\Domain\Interfacing\Screen\ScreenId;
use SmartResponsor\Interfacing\Domain\Interfacing\Screen\ScreenSpec;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Screen\ScreenProviderInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Screen\ScreenRegistryInterface;

final class ScreenRegistry implements ScreenRegistryInterface
{
    /** @var array<string, ScreenSpec>|null */
    private ?array $cache = null;

    /** @param iterable<ScreenProviderInterface> $provider */
    public function __construct(private readonly iterable $provider) {}

    /** @return array<string, ScreenSpec> */
    public function all(): array
    {
        if ($this->cache !== null) {
            return $this->cache;
        }

        $map = [];
        foreach ($this->provider as $p) {
            foreach ($p->provide() as $spec) {
                $id = $spec->screenId()->value();
                if (isset($map[$id])) {
                    throw new \LogicException('Duplicate screen id: ' . $id);
                }
                $map[$id] = $spec;
            }
        }

        ksort($map);
        $this->cache = $map;
        return $map;
    }

    public function get(ScreenId $screenId): ScreenSpec
    {
        $id = $screenId->value();
        $all = $this->all();
        if (!isset($all[$id])) {
            throw new \OutOfBoundsException('Unknown screen id: ' . $id);
        }
        return $all[$id];
    }
}
