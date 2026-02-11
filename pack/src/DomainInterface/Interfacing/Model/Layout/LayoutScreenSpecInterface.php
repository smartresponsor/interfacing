<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface;

/**
 *
 */

/**
 *
 */
interface LayoutScreenSpecInterface
{
    /**
     * @return string
     */
    public function getSlug(): string;

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getNavGroup(): string;

    /**
     * @return \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface
     */
    public function getScreenId(): ScreenIdInterface;

    /**
     * @return string|null
     */
    public function getGuardKey(): ?string;

    /**
     * @return array<string,mixed>
     */
    public function getContext(): array;
}
