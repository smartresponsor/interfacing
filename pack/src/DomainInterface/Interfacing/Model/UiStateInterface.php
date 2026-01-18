<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\DomainInterface\Interfacing\Model;

interface UiStateInterface
{
    /**
     * @return array<string,mixed>
     */
    public function toArray(): array;

    public function isEmpty(): bool;
}
