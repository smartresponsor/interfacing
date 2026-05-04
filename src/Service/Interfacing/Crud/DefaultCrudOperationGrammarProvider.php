<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud;

use App\Interfacing\Contract\Crud\CrudOperationGrammar;
use App\Interfacing\Contract\Crud\CrudOperationGrammarInterface;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudOperationGrammarProviderInterface;

final readonly class DefaultCrudOperationGrammarProvider implements CrudOperationGrammarProviderInterface
{
    /** @return array<string, CrudOperationGrammarInterface> */
    public function provide(): array
    {
        return [
            'index' => new CrudOperationGrammar('index', 'Index', 'app_crud_index', '/{resourcePath}/', 'primary'),
            'new' => new CrudOperationGrammar('new', 'New', 'app_crud_new', '/{resourcePath}/new/'),
            'show' => new CrudOperationGrammar('show', 'Show', 'app_crud_show', '/{resourcePath}/{id}'),
            'edit' => new CrudOperationGrammar('edit', 'Edit', 'app_crud_edit', '/{resourcePath}/edit/{id}'),
            'delete' => new CrudOperationGrammar('delete', 'Delete', 'app_crud_delete', '/{resourcePath}/delete/{id}', 'danger'),
        ];
    }

    public function get(string $operation): ?CrudOperationGrammarInterface
    {
        return $this->provide()[$operation] ?? null;
    }
}
