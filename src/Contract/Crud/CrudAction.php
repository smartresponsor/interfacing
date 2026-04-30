<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * @psalm-immutable
 */
final readonly class CrudAction
{
    public function __construct(
        public string $label,
        public string $href,
        public string $variant = 'default',
    ) {
    }
}
