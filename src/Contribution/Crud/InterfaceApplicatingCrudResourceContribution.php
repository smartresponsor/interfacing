<?php

declare(strict_types=1);

namespace App\Interfacing\Contribution\Crud;

use App\Interfacing\ContributionInterface\Crud\InterfaceCrudResourceDescriptorContributionInterface;

final class InterfaceApplicatingCrudResourceContribution extends InterfaceAbstractCrudResourceContribution implements InterfaceCrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('applicating.application', 'Applicating', 'Application', 'application', 'Administrative application flows should eventually converge on the same canonical CRUD grammar.'),
            $this->canonicalResource('applicating.release', 'Applicating', 'Release', 'release', 'Release CRUD path is listed even before the host exposes a concrete generic route.'),
        ];
    }
}
