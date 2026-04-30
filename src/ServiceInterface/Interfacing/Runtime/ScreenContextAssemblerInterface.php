<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Interfacing\Runtime;

use App\Interfacing\Contract\View\LayoutScreenSpecInterface;

interface ScreenContextAssemblerInterface
{
    /**
     * @return array<string,mixed>
     */
    public function contextFor(LayoutScreenSpecInterface $spec): array;
}
