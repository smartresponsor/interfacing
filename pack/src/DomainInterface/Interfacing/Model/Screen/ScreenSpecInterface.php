<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\DomainInterface\Interfacing\Model\Screen;

use App\DomainInterface\Interfacing\Model\ScreenIdInterface;

interface ScreenSpecInterface
{
    public function getId(): ScreenIdInterface;

    public function getTitle(): string;

    public function getTemplate(): string;
}
