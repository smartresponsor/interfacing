<?php

declare(strict_types=1);

namespace App\Interfacing\Catalog;

use App\Interfacing\CatalogInterface\InterfaceScreenSpecCatalogInterface;
use App\Interfacing\Contract\View\InterfaceScreenSpecInterface;
use App\Interfacing\ProviderInterface\InterfaceScreenProviderInterface;

final class InterfaceScreenSpecCatalog implements InterfaceScreenSpecCatalogInterface
{
    /** @var list<InterfaceScreenProviderInterface> */
    private array $provider;
    /** @var array<string, InterfaceScreenSpecInterface>|null */
    private ?array $cache = null;

    public function __construct(iterable $provider)
    {
        $this->provider = [];
        foreach ($provider as $p) {
            if ($p instanceof InterfaceScreenProviderInterface) {
                $this->provider[] = $p;
            }
        }
    }

    public function all(): array
    {
        return array_values($this->build());
    }

    public function get(string $id): InterfaceScreenSpecInterface
    {
        $map = $this->build();
        if (!isset($map[$id])) {
            throw new \RuntimeException('Unknown screenId: '.$id);
        }

        return $map[$id];
    }

    /** @return array<string, InterfaceScreenSpecInterface> */
    private function build(): array
    {
        if (null !== $this->cache) {
            return $this->cache;
        }
        $map = [];
        foreach ($this->provider as $p) {
            foreach ($p->provide() as $s) {
                $map[$s->id()] = $s;
            }
        }
        ksort($map);
        $this->cache = $map;

        return $map;
    }
}
