<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * @psalm-immutable
 */
final readonly class InterfaceCrudSidebarSection
{
    /**
     * @param array<string, scalar|null> $facts
     * @param list<InterfaceCrudAction>  $actions
     */
    public function __construct(
        public string $title,
        public array $facts = [],
        public string $note = '',
        public array $actions = [],
    ) {
    }
}
