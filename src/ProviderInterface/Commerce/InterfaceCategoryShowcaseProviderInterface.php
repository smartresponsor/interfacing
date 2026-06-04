<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Commerce;

/**
 * Provides category storefront data for customer-facing category browsing pages.
 */
interface InterfaceCategoryShowcaseProviderInterface
{
    /**
     * @param array<string, mixed> $criteria
     *
     * @return array<string, mixed>
     */
    public function provide(array $criteria = []): array;
}
