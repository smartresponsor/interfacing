<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Infra\Interfacing\Config;

final class CategoryApiRouteMap
{
    public function __construct(private string $listPath, private string $readPath, private string $savePath) {}

    public function listPath(): string { return $this->listPath; }
    public function readPath(string $id): string { return str_replace('{id}', rawurlencode($id), $this->readPath); }
    public function savePath(string $id): string { return str_replace('{id}', rawurlencode($id), $this->savePath); }
}
