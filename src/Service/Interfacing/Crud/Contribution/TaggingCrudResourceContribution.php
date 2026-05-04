<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class TaggingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('tagging.tag', 'Tagging', 'Tag', 'tag', 'Tag records are the canonical Tagging CRUD root.'),
            $this->canonicalResource('tagging.tag-assignment', 'Tagging', 'Tag assignment', 'tag-assignment', 'Assignment records need visible show/edit/delete route samples.'),
            $this->canonicalResource('tagging.taxonomy', 'Tagging', 'Taxonomy', 'taxonomy', 'Taxonomy CRUD screens support hierarchical tag management.'),
            $this->canonicalResource('tagging.label', 'Tagging', 'Label', 'label', 'Label records are exposed for UI vocabulary alignment.'),
            $this->canonicalResource('tagging.tag-rule', 'Tagging', 'Tag rule', 'tag-rule', 'Rule screens prepare automation and classification workflows.'),
        ];
    }
}
