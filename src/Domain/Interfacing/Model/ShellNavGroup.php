<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Model;

final class ShellNavGroup
{
    /** @param list<ShellNavItem> $item */
    public function __construct(private string $label, private array $item)
    {
        if ($label === '') {
            throw new \InvalidArgumentException('Nav group label must not be empty.');
        }
    }

    public function label(): string { return $this->label; }
    /** @return list<ShellNavItem> */
    public function itemList(): array { return $this->item; }
}
