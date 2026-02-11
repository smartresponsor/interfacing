<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\ServiceInterface\Interfacing\Registry;

    /**
     *
     */

    /**
     *
     */
    interface ScreenDescriptorInterface
{
        /**
         * @return string
         */
        public function screenId(): string;

        /**
         * @return string
         */
        public function title(): string;

        /**
         * @return string|null
         */
        public function navGroup(): ?string;

        /**
         * @return int
         */
        public function navOrder(): int;

        /**
         * @return bool
         */
        public function isVisible(): bool;
}

