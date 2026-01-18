<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Layout;

use SmartResponsor\Interfacing\Domain\Interfacing\Layout\LayoutSpec;

interface LayoutProviderInterface
{
    /** @return LayoutSpec[] */
    public function provide(): array;
}
