<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Screen;

use App\Interfacing\Contract\ValueObject\ScreenIdInterface;
use App\Interfacing\Contract\View\ScreenSpecInterface;
use App\Interfacing\ServiceInterface\Interfacing\Screen\ScreenCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Screen\ScreenProviderInterface;

final class ScreenCatalog implements ScreenCatalogInterface
{
    /** @var array<string, ScreenSpecInterface> */
    private array $map = [];

    /** @param iterable<ScreenProviderInterface> $provider */
    public function __construct(iterable $provider)
    {
        foreach ($provider as $item) {
            foreach ($item->provide() as $spec) {
                $key = $spec->id();
                if (isset($this->map[$key])) {
                    throw new \RuntimeException('Duplicate screen id: '.$key);
                }
                $this->map[$key] = $spec;
            }
        }
    }

    public function all(): array
    {
        return array_values($this->map);
    }

    public function get(ScreenIdInterface $id): ScreenSpecInterface
    {
        $key = $id->value();
        if (!isset($this->map[$key])) {
            throw new \RuntimeException('Unknown screen id: '.$key);
        }

        return $this->map[$key];
    }
}
