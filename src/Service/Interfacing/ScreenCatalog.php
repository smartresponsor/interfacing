<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing;

use App\Interfacing\Contract\View\ScreenSpecInterface;
use App\Interfacing\ServiceInterface\Interfacing\ScreenCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\ScreenProviderInterface;

final class ScreenCatalog implements ScreenCatalogInterface
{
    /** @var list<ScreenProviderInterface> */
    private array $provider;
    /** @var array<string, ScreenSpecInterface>|null */
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

    public function get(string $id): ScreenSpecInterface
    {
        $map = $this->build();
        if (!isset($map[$id])) {
            throw new \RuntimeException('Unknown screenId: '.$id);
        }

        return $map[$id];
    }

    /** @return array<string, ScreenSpecInterface> */
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
