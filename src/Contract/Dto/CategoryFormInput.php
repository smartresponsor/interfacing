<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Contract\Dto;

final class CategoryFormInput
{
    public string $id = '';
    public string $slug = '';
    public string $name = '';
    public string $locale = 'en';
    public string $status = 'active';

    /** @return array<string,string> */
    public function toPayload(): array
    {
        return ['id' => $this->id, 'slug' => $this->slug, 'name' => $this->name, 'locale' => $this->locale, 'status' => $this->status];
    }

    /** @param array<string,mixed> $data */
    public function fillFromArray(array $data): void
    {
        $this->id = (string) ($data['id'] ?? '');
        $this->slug = (string) ($data['slug'] ?? '');
        $this->name = (string) ($data['name'] ?? '');
        $this->locale = (string) ($data['locale'] ?? 'en');
        $this->status = (string) ($data['status'] ?? 'active');
    }
}
