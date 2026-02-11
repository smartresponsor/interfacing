<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing;

use App\Domain\Interfacing\Model\ScreenSpec;
use App\Domain\Interfacing\Value\ScreenId;
use App\ServiceInterface\Interfacing\ScreenCatalogInterface;
use App\ServiceInterface\Interfacing\ScreenProviderInterface;

final class ScreenCatalog implements ScreenCatalogInterface
{
    /** @var list<ScreenProviderInterface> */
    private array $provider;
    /** @var array<string, ScreenSpec>|null */
    private ?array $cache = null;

    public function __construct(iterable $provider)
    {
        $this->provider = [];
        foreach ($provider as $p) {
            if ($p instanceof ScreenProviderInterface) {
                $this->provider[] = $p;
            }
        }
    }

    public function all(): array
    {
        return array_values($this->build());
    }

    public function get(ScreenId $id): ScreenSpec
    {
        $map = $this->build();
        $k = $id->toString();
        if (!isset($map[$k])) {
            throw new \RuntimeException('Unknown screenId: '.$k);
        }
        return $map[$k];
    }

    /** @return array<string, ScreenSpec> */
    private function build(): array
    {
        if ($this->cache !== null) {
            return $this->cache;
        }
        $map = [];
        foreach ($this->provider as $p) {
            foreach ($p->provide() as $s) {
                $map[$s->id()->toString()] = $s;
            }
        }
        ksort($map);
        $this->cache = $map;
        return $map;
    }
}
