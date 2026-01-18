<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Widget\Form;

interface FormHandlerRegistryInterface
{
    public function has(string $id): bool;

    public function get(string $id): FormHandlerInterface;

    /** @return list<string> */
    public function idList(): array;
}
