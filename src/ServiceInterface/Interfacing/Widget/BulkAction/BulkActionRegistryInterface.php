<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Widget\BulkAction;

use App\Domain\Interfacing\Model\BulkAction\BulkActionSpec;

/**
 *
 */

/**
 *
 */
interface BulkActionRegistryInterface
{
    /**
     * @return list<BulkActionSpec>
     */
    public function list(): array;

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool;

    /**
     * @param string $id
     * @return \App\ServiceInterface\Interfacing\Widget\BulkAction\BulkActionHandlerInterface
     */
    public function handler(string $id): BulkActionHandlerInterface;
}
