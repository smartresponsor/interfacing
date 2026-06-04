<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

final class InterfaceShellNavGroup implements InterfaceShellNavGroupInterface
{
    /**
     * @param list<InterfaceShellNavItem> $item
     */
    public function __construct(
        private string $id,
        private readonly string $title,
        private readonly array $item,
    ) {
        $this->id = trim($this->id);
        if ('' === $this->id) {
            throw new \InvalidArgumentException('InterfaceShellNavGroup id must be non-empty.');
        }
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return list<InterfaceShellNavItem>
     */
    public function item(): array
    {
        return $this->item;
    }
}
