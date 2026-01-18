<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\ServiceInterface\Interfacing\Layout;

use App\DomainInterface\Interfacing\Model\Layout\LayoutNavSpecInterface;
use App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;

interface LayoutShellInterface
{
    public function buildNav(string $activeSlug): LayoutNavSpecInterface;

    /**
     * @return array{title:string, nav:LayoutNavSpecInterface, active:LayoutScreenSpecInterface}
     */
    public function build(LayoutScreenSpecInterface $active): array;
}
