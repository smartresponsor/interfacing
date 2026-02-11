<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\DomainInterface\Interfacing\Model\Context;

    /**
     *
     */

    /**
     *
     */
    interface ScreenContextInterface
{
        /**
         * @return string|null
         */
        public function tenantId(): ?string;

        /**
         * @return string|null
         */
        public function userId(): ?string;

        /**
         * @return string|null
         */
        public function locale(): ?string;

    /** @return array<string, mixed> */
    public function extra(): array;
}

