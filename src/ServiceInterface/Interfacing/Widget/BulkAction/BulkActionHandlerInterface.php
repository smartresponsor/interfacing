<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Widget\BulkAction;

use App\Domain\Interfacing\Model\BulkAction\BulkActionResult;

/**
 *
 */

/**
 *
 */
interface BulkActionHandlerInterface
{
    /**
     * @return string
     */
    public function id(): string;

    /**
     * @param list<string> $id
     */
    public function execute(array $id, array $context = []): BulkActionResult;
}
