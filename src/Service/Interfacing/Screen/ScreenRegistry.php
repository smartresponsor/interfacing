<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Service\Interfacing\Screen;

use App\Contract\ValueObject\ScreenIdInterface;
use App\Contract\View\ScreenSpecInterface;
use App\ServiceInterface\Interfacing\Screen\ScreenProviderInterface;
use App\ServiceInterface\Interfacing\Screen\ScreenRegistryInterface;

final class ScreenRegistry implements ScreenRegistryInterface
{
    /** @var array<string, ScreenSpecInterface>|null */
    private ?array $cache = null;

    /** @param iterable<ScreenProviderInterface> $provider */
    public function __construct(private readonly iterable $provider)
    {
    }

    public function all(): array
    {
        if (null !== $this->cache) {
            return $this->cache;
        }

        $cache = [];
        foreach ($this->provider as $p) {
            foreach ($p->provide() as $spec) {
                $cache[$spec->id()] = $spec;
            }
        }

        ksort($cache);
        $this->cache = $cache;

        return $cache;
    }

    public function get(ScreenIdInterface $screenId): ScreenSpecInterface
    {
        $key = $screenId->value();
        $all = $this->all();
        if (!isset($all[$key])) {
            throw new \OutOfBoundsException('Unknown screen id: '.$key);
        }

        return $all[$key];
    }
}
