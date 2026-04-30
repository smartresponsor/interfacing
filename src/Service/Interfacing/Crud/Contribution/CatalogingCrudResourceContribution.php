<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;

final class CatalogingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('cataloging.category', 'Cataloging', 'Category', 'category', 'Category already appears in connected hosts often enough to make it the reference CRUD resource.'),
            $this->canonicalResource('cataloging.collection', 'Cataloging', 'Collection', 'collection', 'Collection follows the same entity/operation grammar as category.'),
        ];
    }
}
