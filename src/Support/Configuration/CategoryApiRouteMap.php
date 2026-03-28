<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Support\Configuration;

final class CategoryApiRouteMap
{
    public function __construct(private readonly string $listPath, private readonly string $readPath, private readonly string $savePath)
    {
    }

    public function listPath(): string
    {
        return $this->listPath;
    }

    public function readPath(string $id): string
    {
        return str_replace('{id}', rawurlencode($id), $this->readPath);
    }

    public function savePath(string $id): string
    {
        return str_replace('{id}', rawurlencode($id), $this->savePath);
    }
}
