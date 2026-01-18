<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Layout\LayoutScreenSpec;

interface LayoutShellInterface
{
    /**
     * @return array<string,mixed>
     */
    public function build(LayoutScreenSpec $activeSpec, array $allSpec): array;
}
