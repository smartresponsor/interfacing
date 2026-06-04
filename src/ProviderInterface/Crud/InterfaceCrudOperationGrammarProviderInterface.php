<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Crud;

use App\Interfacing\Contract\Crud\InterfaceCrudOperationGrammarInterface;

interface InterfaceCrudOperationGrammarProviderInterface
{
    /** @return array<string, InterfaceCrudOperationGrammarInterface> */
    public function provide(): array;

    public function get(string $operation): ?InterfaceCrudOperationGrammarInterface;
}
