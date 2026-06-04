<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * @psalm-immutable
 */
final readonly class InterfaceCrudFormSection
{
    /**
     * @param list<InterfaceCrudFormField> $fields
     */
    public function __construct(
        public string $title,
        public string $description,
        public array $fields,
    ) {
    }
}
