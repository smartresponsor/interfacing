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
final class CategoryApiRouteMap
{
    /**
     * @param string $listPath
     * @param string $readPath
     * @param string $savePath
     */
    public function __construct(private readonly string $listPath, private readonly string $readPath, private readonly string $savePath) {}

    /**
     * @return string
     */
    public function listPath(): string { return $this->listPath; }

    /**
     * @param string $id
     * @return string
     */
    public function readPath(string $id): string { return str_replace('{id}', rawurlencode($id), $this->readPath); }

    /**
     * @param string $id
     * @return string
     */
    public function savePath(string $id): string { return str_replace('{id}', rawurlencode($id), $this->savePath); }
}
