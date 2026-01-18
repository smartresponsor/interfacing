<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Domain\Interfacing\Model;

final class CategoryItemView
{
    public function __construct(
        private string $id,
        private string $slug,
        private string $name,
        private string $locale,
        private string $status
    ) {
        if ($id === '' || $slug === '' || $name === '' || $locale === '') {
            throw new \InvalidArgumentException('CategoryItemView fields must not be empty.');
        }
    }

    /** @return array<string,string> */
    public function toArray(): array
    {
        return ['id' => $this->id, 'slug' => $this->slug, 'name' => $this->name, 'locale' => $this->locale, 'status' => $this->status];
    }
}
