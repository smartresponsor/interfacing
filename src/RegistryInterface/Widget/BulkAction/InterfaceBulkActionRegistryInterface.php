<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\RegistryInterface\Widget\BulkAction;

use App\Interfacing\Contract\View\InterfaceBulkActionSpec;

interface InterfaceBulkActionRegistryInterface
{
    /**
     * @return list<InterfaceBulkActionSpec>
     */
    public function list(): array;

    public function has(string $id): bool;

    public function handler(string $id): InterfaceBulkActionHandlerInterface;
}
