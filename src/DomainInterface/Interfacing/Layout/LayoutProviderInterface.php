<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\DomainInterface\Interfacing\Layout;

use App\Domain\Interfacing\Layout\LayoutSpec;

/**
 *
 */

/**
 *
 */
interface LayoutProviderInterface
{
    /** @return LayoutSpec[] */
    public function provide(): array;
}
