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
    interface LayoutBlockSpecInterface
{
        /**
         * @return string
         */
        public function type(): string;

        /**
         * @return string
         */
        public function key(): string;

    /** @return array<string, mixed> */
    public function props(): array;
}

