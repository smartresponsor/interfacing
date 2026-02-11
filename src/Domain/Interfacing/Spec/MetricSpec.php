<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Domain\Interfacing\Spec;

    /**
     *
     */

    /**
     *
     */
    final readonly class MetricSpec
{
        /**
         * @param string $id
         * @param string $title
         * @param string $value
         * @param string|null $hint
         */
        public function __construct(
        public string  $id,
        public string  $title,
        public string  $value,
        public ?string $hint = null,
    ) {
    }
}

