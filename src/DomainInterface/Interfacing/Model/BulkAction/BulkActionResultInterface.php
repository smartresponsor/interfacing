<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\DomainInterface\Interfacing\Model\BulkAction;

/**
 *
 */

/**
 *
 */
interface BulkActionResultInterface
{
    /**
     * @return string
     */
    public function message(): string;

    /**
     * @return array
     */
    public function removedId(): array;

    /**
     * @return array
     */
    public function updatedId(): array;
}
