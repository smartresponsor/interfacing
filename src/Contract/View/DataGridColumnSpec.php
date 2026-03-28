<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Contract\View;

final class DataGridColumnSpec implements DataGridColumnSpecInterface
{
    public function __construct(
        private string $key,
        private string $title,
        private readonly bool $sortable = true,
    ) {
        $this->key = trim($this->key);
        if ('' === $this->key) {
            throw new \InvalidArgumentException('Column key must be non-empty.');
        }
        $this->title = trim($this->title);
        if ('' === $this->title) {
            $this->title = $this->key;
        }
    }

    public function key(): string
    {
        return $this->key;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function sortable(): bool
    {
        return $this->sortable;
    }
}
