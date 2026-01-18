<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;

interface ScreenContextAssemblerInterface
{
    /**
     * @return array<string,mixed>
     */
    public function contextFor(LayoutScreenSpecInterface $spec): array;
}
