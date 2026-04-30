<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;

final class GenericCategoryCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceContributionInterface
{
    public function provide(): array
    {
        return [
            $this->resource(
                id: 'cruding.generic.category',
                component: 'Cruding',
                label: 'Generic Category CRUD',
                resourcePath: 'category',
                indexRoute: 'app_crud_index',
                indexFallback: '/category/',
                newRoute: 'app_crud_new',
                newFallback: '/category/new/',
                showPattern: '/category/{id}',
                editPattern: '/category/edit/{id}',
                deletePattern: '/category/delete/{id}',
                routeParameters: ['resourcePath' => 'category'],
                note: 'This is the canonical entity/operation CRUD grammar driven by Cruding.',
            ),
        ];
    }
}
