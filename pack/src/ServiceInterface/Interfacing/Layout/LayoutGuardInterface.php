<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;

/**
 *
 */

/**
 *
 */
interface LayoutGuardInterface
{
    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface $spec
     * @return bool
     */
    public function canView(LayoutScreenSpecInterface $spec): bool;
}
