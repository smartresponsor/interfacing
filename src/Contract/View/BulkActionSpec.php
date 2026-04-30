<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

final class BulkActionSpec
{
    public function __construct(
        private string $id,
        private readonly string $title,
        private readonly bool $confirm = true,
    ) {
        $this->id = trim($this->id);
        if ('' === $this->id) {
            throw new \InvalidArgumentException('BulkAction id must be non-empty.');
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

    public function confirm(): bool
    {
        return $this->confirm;
    }
}
