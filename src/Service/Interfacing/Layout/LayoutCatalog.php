<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Service\Interfacing\Layout;

use SmartResponsor\Interfacing\Domain\Interfacing\Layout\LayoutSpec;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Layout\LayoutProviderInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;

final class LayoutCatalog implements LayoutCatalogInterface
{
    /** @var array<string, LayoutSpec>|null */
    private ?array $cache = null;

    /** @param iterable<LayoutProviderInterface> $provider */
    public function __construct(private readonly iterable $provider) {}

    /** @return array<string, LayoutSpec> */
    public function all(): array
    {
        if ($this->cache !== null) {
            return $this->cache;
        }

        $map = [];
        foreach ($this->provider as $p) {
            foreach ($p->provide() as $spec) {
                $k = $spec->layoutKey();
                if (isset($map[$k])) {
                    throw new \LogicException('Duplicate layout key: ' . $k);
                }
                $map[$k] = $spec;
            }
        }

        ksort($map);
        $this->cache = $map;
        return $map;
    }

    public function get(string $layoutKey): LayoutSpec
    {
        $k = trim($layoutKey);
        $all = $this->all();
        if (!isset($all[$k])) {
            throw new \OutOfBoundsException('Unknown layout key: ' . $k);
        }
        return $all[$k];
    }
}
