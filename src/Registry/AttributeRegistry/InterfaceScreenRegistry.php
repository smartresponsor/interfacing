<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Registry\AttributeRegistry;

use App\Interfacing\Contract\View\InterfaceScreenSpecInterface;
use App\Interfacing\ProviderInterface\InterfaceScreenProviderInterface;
use App\Interfacing\RegistryInterface\AttributeRegistry\InterfaceScreenRegistryInterface;

final class InterfaceScreenRegistry implements InterfaceScreenRegistryInterface
{
    /** @var array<string, InterfaceScreenSpecInterface> */
    private array $map = [];

    /** @param iterable<InterfaceScreenProviderInterface> $provider */
    public function __construct(iterable $provider)
    {
        foreach ($provider as $p) {
            foreach ($p->provide() as $screen) {
                $this->map[$screen->id()] = $screen;
            }
        }
    }

    /**
     * @return array|InterfaceScreenSpecInterface[]
     */
    public function all(): array
    {
        return array_values($this->map);
    }

    public function has(string $screenId): bool
    {
        return isset($this->map[$screenId]);
    }

    public function get(string $screenId): InterfaceScreenSpecInterface
    {
        if (!$this->has($screenId)) {
            throw new \InvalidArgumentException(sprintf('Unknown screenId: %s', $screenId));
        }

        return $this->map[$screenId];
    }
}
