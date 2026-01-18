<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\DomainInterface\Interfacing\Model;

interface WidgetIdInterface
{
    public function toString(): string;

    public function equals(self $other): bool;
}
