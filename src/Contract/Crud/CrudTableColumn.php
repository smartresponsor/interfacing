<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * @psalm-immutable
 */
final readonly class CrudTableColumn
{
    public function __construct(
        public string $key,
        public string $label,
        public bool $isCode = false,
        public bool $isStatus = false,
    ) {
    }
}
