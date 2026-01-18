<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\ServiceInterface\Interfacing\Runtime;

use App\DomainInterface\Interfacing\Model\ScreenIdInterface;
use App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

interface ScreenRegistryInterface
{
    public function has(ScreenIdInterface $id): bool;

    public function get(ScreenIdInterface $id): ScreenSpecInterface;

    /**
     * @return list<ScreenSpecInterface>
     */
    public function all(): array;
}
