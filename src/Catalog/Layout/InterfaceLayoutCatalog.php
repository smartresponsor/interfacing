<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Catalog\Layout;

use App\Interfacing\CatalogInterface\Layout\InterfaceLayoutCatalogInterface;
use App\Interfacing\Contract\View\InterfaceLayoutScreenSpecInterface;
use App\Interfacing\ProviderInterface\Layout\InterfaceLayoutProviderInterface;

final class InterfaceLayoutCatalog implements InterfaceLayoutCatalogInterface
{
    /** @var array<string, InterfaceLayoutScreenSpecInterface>|null */
    private ?array $cache = null;

    /** @param iterable<InterfaceLayoutProviderInterface> $provider */
    public function __construct(private readonly iterable $provider)
    {
    }

    /** @return array<string, InterfaceLayoutScreenSpecInterface> */
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

    /** @return array<string, InterfaceLayoutScreenSpecInterface> */
    public function list(): array
    {
        return $this->all();
    }

    public function has(string $layoutKey): bool
    {
        return null !== $this->find($layoutKey);
    }

    public function find(string $layoutKey): ?InterfaceLayoutScreenSpecInterface
    {
        $k = trim($layoutKey);

        return $this->all()[$k] ?? null;
    }

    public function findBySlug(string $slug): ?InterfaceLayoutScreenSpecInterface
    {
        return $this->find($slug);
    }

    public function get(string $layoutKey): InterfaceLayoutScreenSpecInterface
    {
        $k = trim($layoutKey);
        $all = $this->all();
        if (!isset($all[$k])) {
            throw new \OutOfBoundsException('Unknown layout id: '.$k);
        }

        return $all[$k];
    }
}
