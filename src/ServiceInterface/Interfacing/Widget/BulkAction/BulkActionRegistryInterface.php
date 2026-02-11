<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Widget\BulkAction;

use App\Domain\Interfacing\Model\BulkAction\BulkActionSpec;

interface BulkActionRegistryInterface
{
    /**
     * @return list<BulkActionSpec>
     */
    public function list(): array;

    public function has(string $id): bool;

    public function handler(string $id): BulkActionHandlerInterface;
}
