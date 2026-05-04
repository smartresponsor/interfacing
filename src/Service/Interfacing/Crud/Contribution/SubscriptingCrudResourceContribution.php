<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class SubscriptingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('subscripting.subscription', 'Subscripting', 'Subscription', 'subscription', 'Primary commerce subscription surface for recurring access, lifecycle state and account relationship.'),
            $this->canonicalResource('subscripting.subscription-plan', 'Subscripting', 'Subscription plan', 'subscription-plan', 'Plan catalog for recurring commerce offers, pricing linkage and entitlement composition.'),
            $this->canonicalResource('subscripting.subscription-price', 'Subscripting', 'Subscription price', 'subscription-price', 'Recurring price surface linked to plans, currencies, billing intervals and promotional adjustments.'),
            $this->canonicalResource('subscripting.subscription-entitlement', 'Subscripting', 'Subscription entitlement', 'subscription-entitlement', 'Entitlement surface for feature access, quota and plan capability grants.'),
            $this->canonicalResource('subscripting.subscription-event', 'Subscripting', 'Subscription event', 'subscription-event', 'Lifecycle event/audit stream for trial, activation, renewal, pause, cancellation and expiration.'),
            $this->canonicalResource('subscripting.billing-cycle', 'Subscripting', 'Billing cycle', 'billing-cycle', 'Billing-cycle model for renewal cadence, trial windows and recurring invoice schedule previews.'),
        ];
    }
}
