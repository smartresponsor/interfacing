<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\ServiceInterface\Interfacing\View;

    /**
     *
     */

    /**
     *
     */
    interface ShellViewBuilderInterface
{
    /** @return array<string, mixed> */
    public function build(string $activeScreenId): array;
}

