<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface;

interface ScreenSpecInterface
{
    public function getId(): ScreenIdInterface;

    public function getTitle(): string;

    public function getTemplate(): string;
}
