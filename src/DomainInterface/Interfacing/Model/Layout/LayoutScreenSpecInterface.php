<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\DomainInterface\Interfacing\Model\Layout;

    /**
     *
     */

    /**
     *
     */
    interface LayoutScreenSpecInterface
{
    /** @return array<int, LayoutBlockSpecInterface> */
    public function block(): array;
}

