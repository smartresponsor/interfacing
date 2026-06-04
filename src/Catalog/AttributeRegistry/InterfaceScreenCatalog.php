<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Catalog\AttributeRegistry;

use App\Interfacing\CatalogInterface\AttributeRegistry\InterfaceScreenCatalogInterface;
use App\Interfacing\DescriptorInterface\AttributeRegistry\InterfaceScreenDescriptorInterface;

final class InterfaceScreenCatalog implements InterfaceScreenCatalogInterface
{
    /** @var array<string, InterfaceScreenDescriptorInterface> */
    private array $screen = [];

    public function add(InterfaceScreenDescriptorInterface $descriptor): void
    {
        $this->screen[$descriptor->screenId()] = $descriptor;
    }

    /**
     * @return array|InterfaceScreenDescriptorInterface[]
     */
    public function all(): array
    {
        $list = array_values($this->screen);
        usort($list, static function (InterfaceScreenDescriptorInterface $a, InterfaceScreenDescriptorInterface $b): int {
            return $a->navOrder() <=> $b->navOrder();
        });

        return $list;
    }

    public function get(string $screenId): InterfaceScreenDescriptorInterface
    {
        if (!isset($this->screen[$screenId])) {
            throw new \RuntimeException('Interfacing screen not found: '.$screenId);
        }

        return $this->screen[$screenId];
    }
}
