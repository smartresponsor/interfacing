<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface;

interface LayoutScreenSpecInterface
{
    public function getSlug(): string;

    public function getTitle(): string;

    public function getNavGroup(): string;

    public function getScreenId(): ScreenIdInterface;

    public function getGuardKey(): ?string;

    /**
     * @return array<string,mixed>
     */
    public function getContext(): array;
}
