<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Registry;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

interface ScreenRegistryInterface
{
    /** @return array<int, ScreenSpecInterface> */
    public function all(): array;

    public function has(string $screenId): bool;

    public function get(string $screenId): ScreenSpecInterface;
}

