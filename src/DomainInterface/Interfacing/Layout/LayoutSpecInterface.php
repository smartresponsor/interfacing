<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Layout;

interface LayoutSpecInterface
{
    public function id(): LayoutIdInterface;
    public function title(): string;
    public function twigPath(): string;
}

