<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\ServiceInterface\Interfacing\Registry;

    use App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

    /**
     *
     */

    /**
     *
     */
    interface ScreenRegistryInterface
{
    /** @return array<int, ScreenSpecInterface> */
    public function all(): array;

    /**
     * @param string $screenId
     * @return bool
     */
    public function has(string $screenId): bool;

    /**
     * @param string $screenId
     * @return \App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface
     */
    public function get(string $screenId): ScreenSpecInterface;
}

