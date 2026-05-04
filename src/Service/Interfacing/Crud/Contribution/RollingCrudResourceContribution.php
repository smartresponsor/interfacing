<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class RollingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('rolling.rollout', 'Rolling', 'Rollout', 'rollout', 'Rollout is the canonical Rolling CRUD root.'),
            $this->canonicalResource('rolling.feature-flag', 'Rolling', 'Feature flag', 'feature-flag', 'Feature flag screens mirror the operational controls normally expected from admin tooling.'),
            $this->canonicalResource('rolling.release-window', 'Rolling', 'Release window', 'release-window', 'Release windows get route-compatible CRUD visibility.'),
            $this->canonicalResource('rolling.cohort', 'Rolling', 'Cohort', 'cohort', 'Cohort CRUD frames support staged release workflows.'),
            $this->canonicalResource('rolling.experiment', 'Rolling', 'Experiment', 'experiment', 'Experiment screens prepare A/B and rollout audit surfaces.'),
        ];
    }
}
