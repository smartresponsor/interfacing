<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Infra\Interfacing\Config;

/**
 *
 */

/**
 *
 */
final class InterfacingConfig
{
    /**
     * @param string $categoryApiBaseUrl
     * @param int $categoryApiTimeoutMs
     */
    public function __construct(private string $categoryApiBaseUrl, private int $categoryApiTimeoutMs)
    {
        $this->categoryApiBaseUrl = rtrim((string)$this->categoryApiBaseUrl, '/');
        $this->categoryApiTimeoutMs = max(250, (int)$this->categoryApiTimeoutMs);
    }

    /**
     * @return string
     */
    public function categoryApiBaseUrl(): string { return $this->categoryApiBaseUrl; }

    /**
     * @return int
     */
    public function categoryApiTimeoutMs(): int { return $this->categoryApiTimeoutMs; }
}
