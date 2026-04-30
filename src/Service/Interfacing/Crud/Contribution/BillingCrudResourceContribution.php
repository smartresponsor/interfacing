<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;

final class BillingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('billing.invoice', 'Billing', 'Invoice', 'invoice', 'Canonical CRUD route grammar for invoice workbenches.'),
            $this->canonicalResource('billing.meter', 'Billing', 'Meter', 'meter', 'Complements the custom meter screens with their underlying generic CRUD entry points.'),
        ];
    }
}
