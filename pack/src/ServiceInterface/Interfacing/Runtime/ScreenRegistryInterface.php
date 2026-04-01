<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

/**
 *
 */

/**
 *
 */
interface ScreenRegistryInterface
{
    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface $id
     * @return bool
     */
    public function has(ScreenIdInterface $id): bool;

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface $id
     * @return \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface
     */
    public function get(ScreenIdInterface $id): ScreenSpecInterface;

    /**
     * @return list<ScreenSpecInterface>
     */
    public function all(): array;
}
