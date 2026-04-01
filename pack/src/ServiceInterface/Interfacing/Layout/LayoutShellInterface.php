<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutNavSpecInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;

/**
 *
 */

/**
 *
 */
interface LayoutShellInterface
{
    /**
     * @param string $activeSlug
     * @return \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutNavSpecInterface
     */
    public function buildNav(string $activeSlug): LayoutNavSpecInterface;

    /**
     * @return array{title:string, nav:LayoutNavSpecInterface, active:LayoutScreenSpecInterface}
     */
    public function build(LayoutScreenSpecInterface $active): array;
}
