<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Service\Interfacing\Layout;

use App\Contract\View\LayoutScreenSpecInterface;
use App\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\ServiceInterface\Interfacing\Layout\LayoutProviderInterface;

final class LayoutCatalog implements LayoutCatalogInterface
{
    /** @var array<string, LayoutScreenSpecInterface>|null */
    private ?array $cache = null;

    /** @param iterable<LayoutProviderInterface> $provider */
    public function __construct(private readonly iterable $provider)
    {
    }

    /** @return array<string, LayoutScreenSpecInterface> */
    public function all(): array
    {
        if (null !== $this->cache) {
            return $this->cache;
        }

        $map = [];
        foreach ($this->provider as $p) {
            foreach ($p->provide() as $spec) {
                $k = trim($spec->id());
                if ('' === $k) {
                    throw new \LogicException('Empty layout id is not allowed.');
                }
                if (isset($map[$k])) {
                    throw new \LogicException('Duplicate layout id: '.$k);
                }
                $map[$k] = $spec;
            }
        }

        ksort($map);
        $this->cache = $map;

        return $map;
    }

    public function get(string $layoutKey): LayoutScreenSpecInterface
    {
        $k = trim($layoutKey);
        $all = $this->all();
        if (!isset($all[$k])) {
            throw new \OutOfBoundsException('Unknown layout id: '.$k);
        }

        return $all[$k];
    }
}
