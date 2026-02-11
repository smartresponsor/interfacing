<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Runtime;

use App\Domain\Interfacing\Value\ScreenId;

/**
 *
 */

/**
 *
 */
interface ScreenRegistryInterface
{
    /**
     * @param \App\Domain\Interfacing\Value\ScreenId $id
     * @return bool
     */
    public function has(ScreenId $id): bool;

    /**
     * @param \App\Domain\Interfacing\Value\ScreenId $id
     * @return string
     */
    public function componentName(ScreenId $id): string;
}
