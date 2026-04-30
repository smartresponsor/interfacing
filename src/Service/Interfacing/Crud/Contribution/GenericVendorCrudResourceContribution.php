<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;

final class GenericVendorCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceContributionInterface
{
    public function provide(): array
    {
        return [
            $this->resource(
                id: 'cruding.generic.vendor',
                component: 'Cruding',
                label: 'Generic Vendor CRUD',
                resourcePath: 'vendor',
                indexRoute: 'app_crud_index',
                indexFallback: '/vendor/',
                newRoute: 'app_crud_new',
                newFallback: '/vendor/new/',
                showPattern: '/vendor/{id}',
                editPattern: '/vendor/edit/{id}',
                deletePattern: '/vendor/delete/{id}',
                routeParameters: ['resourcePath' => 'vendor'],
                note: 'Useful for checking the generic CRUD bridge independently from component-specific screens.',
            ),
        ];
    }
}
