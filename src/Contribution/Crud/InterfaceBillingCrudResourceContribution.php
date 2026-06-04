<?php

declare(strict_types=1);

namespace App\Interfacing\Contribution\Crud;

use App\Interfacing\ContributionInterface\Crud\InterfaceCrudResourceDescriptorContributionInterface;

final class InterfaceBillingCrudResourceContribution extends InterfaceAbstractCrudResourceContribution implements InterfaceCrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('billing.invoice', 'Billing', 'Invoice', 'invoice', 'Canonical CRUD route grammar for invoice workbenches.'),
            $this->canonicalResource('billing.meter', 'Billing', 'Meter', 'meter', 'Complements the custom meter screens with their underlying generic CRUD entry points.'),
        ];
    }
}
