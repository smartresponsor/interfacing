<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;

final class ExchangingCrudResourceContribution extends AbstractCrudResourceContribution implements CrudResourceDescriptorContributionInterface
{
    public function provide(): array
    {
        return [
            $this->canonicalResource('exchanging.exchange-rate', 'Exchanging', 'Exchange rate', 'exchange-rate', 'Commerce exchange-rate table for multi-currency catalog, checkout, billing and reporting flows.'),
            $this->canonicalResource('exchanging.exchange-pair', 'Exchanging', 'Exchange pair', 'exchange-pair', 'Source/target currency-pair configuration for conversion and quote workflows.'),
            $this->canonicalResource('exchanging.exchange-quote', 'Exchanging', 'Exchange quote', 'exchange-quote', 'Operator-visible quote surface for price conversion, order repricing and settlement previews.'),
            $this->canonicalResource('exchanging.conversion-rule', 'Exchanging', 'Conversion rule', 'conversion-rule', 'Conversion rules, rounding policy and commerce tolerance boundaries before downstream money consumers apply values.'),
            $this->canonicalResource('exchanging.rate-provider', 'Exchanging', 'Rate provider', 'rate-provider', 'Provider/source configuration for imported or manually maintained exchange rates.'),
        ];
    }
}
