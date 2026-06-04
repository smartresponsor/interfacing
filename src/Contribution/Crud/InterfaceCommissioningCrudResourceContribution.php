<?php

declare(strict_types=1);

namespace App\Interfacing\Contribution\Crud;

use App\Interfacing\ContributionInterface\Crud\InterfaceCrudResourceDescriptorContributionInterface;

final class InterfaceCommissioningCrudResourceContribution extends InterfaceAbstractCrudResourceContribution implements InterfaceCrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('commissioning.commission-plan', 'Commissioning', 'Commission plan', 'commission-plan', 'Partner/affiliate commission plan catalog for e-commerce revenue sharing.'),
            $this->canonicalResource('commissioning.commission-rule', 'Commissioning', 'Commission rule', 'commission-rule', 'Rule surface for rate tiers, eligibility, product/interfacing/showcase/category scope and order-value thresholds.'),
            $this->canonicalResource('commissioning.commission-agreement', 'Commissioning', 'Commission agreement', 'commission-agreement', 'Agreement surface linking vendors, affiliates, partners or agents to commission plans.'),
            $this->canonicalResource('commissioning.commission-accrual', 'Commissioning', 'Commission accrual', 'commission-accrual', 'Accrual ledger surface for earned commission before payout or adjustment.'),
            $this->canonicalResource('commissioning.commission-payout', 'Commissioning', 'Commission payout', 'commission-payout', 'Payout review surface connected to Paying/Vendoring settlement workflows.'),
            $this->canonicalResource('commissioning.commission-statement', 'Commissioning', 'Commission statement', 'commission-statement', 'Statement surface for partner-visible earned, held, adjusted and paid commission totals.'),
        ];
    }
}
