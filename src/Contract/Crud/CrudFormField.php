<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * @psalm-immutable
 */
final readonly class CrudFormField
{
    /**
     * @param list<array{value:string,label:string}> $options
     */
    public function __construct(
        public string $name,
        public string $label,
        public string $type = 'text',
        public string $value = '',
        public string $placeholder = '',
        public string $helpText = '',
        public array $options = [],
        public bool $required = false,
        public string $validationState = 'default',
        public string $errorText = '',
    ) {
    }
}
