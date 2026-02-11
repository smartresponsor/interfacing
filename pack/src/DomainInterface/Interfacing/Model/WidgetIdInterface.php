<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model;

/**
 *
 */

/**
 *
 */
interface WidgetIdInterface
{
    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\WidgetIdInterface $other
     * @return bool
     */
    public function equals(self $other): bool;
}
