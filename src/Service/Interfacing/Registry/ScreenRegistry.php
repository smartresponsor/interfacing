<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Registry;

use App\Interfacing\Contract\View\ScreenSpecInterface;
use App\Interfacing\ServiceInterface\Interfacing\Provider\ScreenProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Registry\ScreenRegistryInterface;

final class ScreenRegistry implements ScreenRegistryInterface
{
    /** @var array<string, ScreenSpecInterface> */
    private array $map = [];

    /** @param iterable<ScreenProviderInterface> $provider */
    public function __construct(iterable $provider)
    {
        foreach ($provider as $p) {
            foreach ($p->provide() as $screen) {
                $this->map[$screen->id()] = $screen;
            }
        }
    }

    /**
     * @return array|ScreenSpecInterface[]
     */
    public function all(): array
    {
        return array_values($this->map);
    }

    public function has(string $screenId): bool
    {
        return isset($this->map[$screenId]);
    }

    public function get(string $screenId): ScreenSpecInterface
    {
        if (!$this->has($screenId)) {
            throw new \InvalidArgumentException(sprintf('Unknown screenId: %s', $screenId));
        }

        return $this->map[$screenId];
    }
}
