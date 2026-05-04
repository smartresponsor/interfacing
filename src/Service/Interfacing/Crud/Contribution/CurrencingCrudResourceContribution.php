<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class CurrencingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('currencing.currency', 'Currencing', 'Currency', 'currency', 'ISO currency code catalog for e-commerce pricing, checkout, billing and settlement surfaces.'),
            $this->canonicalResource('currencing.currency-metadata', 'Currencing', 'Currency metadata', 'currency-metadata', 'Currency display names, symbols, minor-unit policy and commerce-facing presentation metadata.'),
            $this->canonicalResource('currencing.currency-minor-unit', 'Currencing', 'Currency minor unit', 'currency-minor-unit', 'Minor-unit rules required for prices, totals, invoices, refunds and payout calculations.'),
            $this->canonicalResource('currencing.money-format', 'Currencing', 'Money format', 'money-format', 'Locale-aware money formatting policy used by storefront, admin tables and billing statements.'),
            $this->canonicalResource('currencing.money-normalization', 'Currencing', 'Money normalization', 'money-normalization', 'Normalization surface for amount/currency pairs before adjacent pricing, paying and ordering flows consume them.'),
        ];
    }
}
