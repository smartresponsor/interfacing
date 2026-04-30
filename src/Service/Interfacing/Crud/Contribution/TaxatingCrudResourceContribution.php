<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;

final class TaxatingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('taxating.taxation-api', 'Taxating', 'Taxation API', 'taxation-api', 'Canonical CRUD path surfaced even when the host currently exposes mostly API-only routes.'),
            $this->canonicalResource('taxating.taxation-rate', 'Taxating', 'Taxation rate', 'taxation-rate', 'Useful for validating generic CRUD before component-specific tax consoles exist.'),
            $this->canonicalResource('taxating.taxation-zone', 'Taxating', 'Taxation zone', 'taxation-zone', 'Taxation zone CRUD path follows the same entity/operation grammar.'),
            $this->canonicalResource('taxating.taxation-rate-value', 'Taxating', 'Taxation rate value', 'taxation-rate-value', 'Rate value CRUD path is listed proactively for future host hookups.'),
            $this->canonicalResource('taxating.product-taxation', 'Taxating', 'Product taxation', 'product-taxation', 'Product taxation is surfaced as a first-class CRUD resource.'),
            $this->canonicalResource('taxating.en-use', 'Taxating', 'EN Use', 'en-use', 'Internal taxation entity still receives canonical CRUD links for discoverability.'),
        ];
    }
}
