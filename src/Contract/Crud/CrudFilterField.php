<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * @psalm-immutable
 */
final readonly class CrudFilterField
{
    /**
     * @param list<array{value:string,label:string}> $options
     */
    public function __construct(
        public string $name,
        public string $label,
        public string $type = 'text',
        public string $value = '',
        public array $options = [],
        public string $placeholder = '',
        public string $helpText = '',
    ) {
    }
}
