<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;

final class CategoryAdminCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceContributionInterface
{
    public function provide(): array
    {
        return [
            $this->resource(
                id: 'catalog.category',
                component: 'Cataloging',
                label: 'Category',
                resourcePath: 'category',
                indexRoute: 'admin_category_index',
                indexFallback: '/admin/category',
                newRoute: 'admin_category_new',
                newFallback: '/admin/category/new',
                showPattern: '/category/{id}',
                editPattern: '/category/edit/{id}',
                deletePattern: '/category/delete/{id}',
                note: 'Category already has explicit admin routes and also maps naturally to the generic CRUD path grammar.',
            ),
        ];
    }
}
