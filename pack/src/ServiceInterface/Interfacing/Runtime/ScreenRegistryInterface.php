<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

interface ScreenRegistryInterface
{
    public function has(ScreenIdInterface $id): bool;

    public function get(ScreenIdInterface $id): ScreenSpecInterface;

    /**
     * @return list<ScreenSpecInterface>
     */
    public function all(): array;
}
