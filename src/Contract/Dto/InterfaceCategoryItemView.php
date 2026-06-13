<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Contract\Dto;

final class InterfaceCategoryItemView
{
    public function __construct(
        private readonly string $id,
        private readonly string $slug,
        private readonly string $nameEntity,
        private readonly string $locale,
        private readonly string $status,
    ) {
        if ('' === $id || '' === $slug || '' === $nameEntity || '' === $locale) {
            throw new \InvalidArgumentException('InterfaceCategoryItemView fields must not be empty.');
        }
    }

    /** @return array<string,string> */
    public function toArray(): array
    {
        return ['id' => $this->id, 'slug' => $this->slug, 'nameEntity' => $this->nameEntity, 'locale' => $this->locale, 'status' => $this->status];
    }
}
