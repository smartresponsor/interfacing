<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\DataGrid;

final class DataGridRow
{
    public function __construct(private string $id, private array $cell)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function cell(): array
    {
        return $this->cell;
    }
}
