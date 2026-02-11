<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Infra\Interfacing\Config;

final class InterfacingConfig
{
    public function __construct(private string $categoryApiBaseUrl, private int $categoryApiTimeoutMs)
    {
        $this->categoryApiBaseUrl = rtrim((string)$this->categoryApiBaseUrl, '/');
        $this->categoryApiTimeoutMs = max(250, (int)$this->categoryApiTimeoutMs);
    }

    public function categoryApiBaseUrl(): string { return $this->categoryApiBaseUrl; }
    public function categoryApiTimeoutMs(): int { return $this->categoryApiTimeoutMs; }
}
