<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;

final class VendoringCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('vendoring.vendor', 'Vendoring', 'Vendor', 'vendor', 'Vendor is one of the primary generic CRUD resources and should always be visible.'),
            $this->canonicalResource('vendoring.vendor-transaction', 'Vendoring', 'Vendor transaction', 'vendor-transaction', 'Vendor transaction CRUD path complements the runtime and ops routes already present in connected hosts.'),
            $this->canonicalResource('vendoring.vendor-profile', 'Vendoring', 'Vendor profile', 'vendor-profile', 'Profile CRUD path is listed even when the host currently exposes it only as API endpoints.'),
            $this->canonicalResource('vendoring.payout', 'Vendoring', 'Payout', 'payout', 'Payout CRUD path provides a generic entry surface next to custom payout flows.'),
            $this->canonicalResource('vendoring.payout-account', 'Vendoring', 'Payout account', 'payout-account', 'Payout account CRUD path is shown proactively for upcoming host wiring.'),
        ];
    }
}
