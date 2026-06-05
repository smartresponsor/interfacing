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
            'index' => new InterfaceCrudOperationGrammar('index', 'Index', 'host_crud_index', '/{resourcePath}/', 'primary'),
            'new' => new InterfaceCrudOperationGrammar('new', 'New', 'host_crud_new', '/{resourcePath}/new/'),
            'show' => new InterfaceCrudOperationGrammar('show', 'Show', 'host_crud_show', '/{resourcePath}/{id}'),
            'edit' => new InterfaceCrudOperationGrammar('edit', 'Edit', 'host_crud_edit', '/{resourcePath}/edit/{id}'),
            'delete' => new InterfaceCrudOperationGrammar('delete', 'Delete', 'host_crud_delete', '/{resourcePath}/delete/{id}', 'danger'),
        ];
    }

    public function get(string $operation): ?InterfaceCrudOperationGrammarInterface
    {
        return $this->provide()[$operation] ?? null;
    }
}
