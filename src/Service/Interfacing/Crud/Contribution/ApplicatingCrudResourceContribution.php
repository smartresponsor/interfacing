<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;

final class ApplicatingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('applicating.application', 'Applicating', 'Application', 'application', 'Administrative application flows should eventually converge on the same canonical CRUD grammar.'),
            $this->canonicalResource('applicating.release', 'Applicating', 'Release', 'release', 'Release CRUD path is listed even before the host exposes a concrete generic route.'),
        ];
    }
}
