<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\ClientInterface\CategoryApi;

use App\Interfacing\Contract\Dto\InterfaceCategoryItemView;

interface InterfaceCategoryApiClientInterface
{
    /** @return array{item:list<InterfaceCategoryItemView>, nextCursor:?string} */
    public function list(string $query, ?string $cursor, int $limit): array;

    /** @return array<string,mixed> */
    public function read(string $id): array;

    /** @param array<string,mixed> $payload @return array<string,mixed> */
    public function save(string $id, array $payload): array;
}
