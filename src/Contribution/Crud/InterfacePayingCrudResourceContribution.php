<?php

declare(strict_types=1);

namespace App\Interfacing\Contribution\Crud;

use App\Interfacing\ContributionInterface\Crud\InterfaceCrudResourceDescriptorContributionInterface;

final class InterfacePayingCrudResourceContribution extends InterfaceAbstractCrudResourceContribution implements InterfaceCrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('paying.payment', 'Paying', 'Payment', 'payment', 'Primary payment CRUD surface for settlement and operational review.'),
            $this->canonicalResource('paying.payment-intent', 'Paying', 'Payment intent', 'payment-intent', 'Payment intent handoff prepares host screens before provider-specific flows are connected.'),
            $this->canonicalResource('paying.payment-method', 'Paying', 'Payment method', 'payment-method', 'Payment method records need index/new/edit visibility similar to Easy Admin defaults.'),
            $this->canonicalResource('paying.refund', 'Paying', 'Refund', 'refund', 'Refund CRUD entry complements payment operation actions.'),
            $this->canonicalResource('paying.transaction', 'Paying', 'Transaction', 'transaction', 'Transaction records are visible for audit, reconciliation and operator workflows.'),
        ];
    }
}
