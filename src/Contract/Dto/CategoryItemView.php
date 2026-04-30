<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Contract\Dto;

final class CategoryItemView
{
    public function __construct(
        private readonly string $id,
        private readonly string $slug,
        private readonly string $name,
        private readonly string $locale,
        private readonly string $status,
    ) {
        if ('' === $id || '' === $slug || '' === $name || '' === $locale) {
            throw new \InvalidArgumentException('CategoryItemView fields must not be empty.');
        }
    }

    /** @return array<string,string> */
    public function toArray(): array
    {
        return ['id' => $this->id, 'slug' => $this->slug, 'name' => $this->name, 'locale' => $this->locale, 'status' => $this->status];
    }
}
