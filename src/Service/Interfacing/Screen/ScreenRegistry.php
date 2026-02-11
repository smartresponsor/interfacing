<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Service\Interfacing\Screen;

use App\Domain\Interfacing\Screen\ScreenId;
use App\Domain\Interfacing\Screen\ScreenSpec;
use App\DomainInterface\Interfacing\Screen\ScreenProviderInterface;
use App\ServiceInterface\Interfacing\Screen\ScreenRegistryInterface;

/**
 *
 */

/**
 *
 */
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

    /**
     * @param \App\Domain\Interfacing\Screen\ScreenId $screenId
     * @return \App\Domain\Interfacing\Screen\ScreenSpec
     */
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
