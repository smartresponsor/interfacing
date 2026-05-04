<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class LocatingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('locating.location', 'Locating', 'Location', 'location', 'Location records are the canonical Locating CRUD surface.'),
            $this->canonicalResource('locating.address', 'Locating', 'Address', 'address', 'Address workbench URLs remain visible even when Addressing is not connected.'),
            $this->canonicalResource('locating.region', 'Locating', 'Region', 'region', 'Region CRUD screens support geographic grouping.'),
            $this->canonicalResource('locating.zone', 'Locating', 'Zone', 'zone', 'Zone CRUD frames support fulfillment and taxation boundaries.'),
            $this->canonicalResource('locating.geocode-result', 'Locating', 'Geocode result', 'geocode-result', 'Geocode result records are inspectable through the generic bridge.'),
        ];
    }
}
