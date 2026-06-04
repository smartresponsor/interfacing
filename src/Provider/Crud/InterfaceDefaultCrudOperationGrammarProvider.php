<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Crud;

use App\Interfacing\Contract\Crud\InterfaceCrudOperationGrammar;
use App\Interfacing\Contract\Crud\InterfaceCrudOperationGrammarInterface;
use App\Interfacing\ProviderInterface\Crud\InterfaceCrudOperationGrammarProviderInterface;

final readonly class InterfaceDefaultCrudOperationGrammarProvider implements InterfaceCrudOperationGrammarProviderInterface
{
    /** @return array<string, InterfaceCrudOperationGrammarInterface> */
    public function provide(): array
    {
        return [
            'index' => new InterfaceCrudOperationGrammar('index', 'Index', 'app_crud_index', '/interfacing/crud/{resourcePath}/', 'primary'),
            'new' => new InterfaceCrudOperationGrammar('new', 'New', 'app_crud_new', '/interfacing/crud/{resourcePath}/new/'),
            'show' => new InterfaceCrudOperationGrammar('show', 'Show', 'app_crud_show', '/interfacing/crud/{resourcePath}/{id}'),
            'edit' => new InterfaceCrudOperationGrammar('edit', 'Edit', 'app_crud_edit', '/interfacing/crud/{resourcePath}/edit/{id}'),
            'delete' => new InterfaceCrudOperationGrammar('delete', 'Delete', 'app_crud_delete', '/interfacing/crud/{resourcePath}/delete/{id}', 'danger'),
        ];
    }

    public function get(string $operation): ?InterfaceCrudOperationGrammarInterface
    {
        return $this->provide()[$operation] ?? null;
    }
}
