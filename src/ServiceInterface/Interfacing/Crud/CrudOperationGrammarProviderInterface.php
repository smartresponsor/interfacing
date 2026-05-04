<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Crud;

use App\Interfacing\Contract\Crud\CrudOperationGrammarInterface;

interface CrudOperationGrammarProviderInterface
{
    /** @return array<string, CrudOperationGrammarInterface> */
    public function provide(): array;

    public function get(string $operation): ?CrudOperationGrammarInterface;
}
