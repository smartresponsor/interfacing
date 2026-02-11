<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\DataGrid;

/**
 *
 */

/**
 *
 */
final class DataGridRow
{
    /**
     * @param string $id
     * @param array $cell
     */
    public function __construct(private readonly string $id, private readonly array $cell)
    {
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function cell(): array
    {
        return $this->cell;
    }
}
