<?php

declare(strict_types=1);

namespace App\Interfacing\Contribution\Crud;

use App\Interfacing\ContributionInterface\Crud\InterfaceCrudResourceDescriptorContributionInterface;

final class InterfaceDiscoveringCrudResourceContribution extends InterfaceAbstractCrudResourceContribution implements InterfaceCrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('discovering.discovery', 'Discovering', 'Discovery', 'discovery', 'Discovery is the canonical Discovering CRUD root.'),
            $this->canonicalResource('discovering.recommendation', 'Discovering', 'Recommendation', 'recommendation', 'Recommendation screens give the discovery layer a concrete admin route surface.'),
            $this->canonicalResource('discovering.insight', 'Discovering', 'Insight', 'insight', 'Insight records are exposed for review and curation.'),
            $this->canonicalResource('discovering.discovery-query', 'Discovering', 'Discovery query', 'discovery-query', 'Discovery query records prepare search/discovery QA workflows.'),
            $this->canonicalResource('discovering.facet-state', 'Discovering', 'Facet state', 'facet-state', 'Facet states support filter and product-discovery screens.'),
        ];
    }
}
