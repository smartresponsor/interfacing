<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Commerce;

/**
 * Provides project storefront data for customer-facing project browsing pages.
 */
interface InterfaceProjectShowcaseProviderInterface
{
    /**
     * @param array<string, mixed> $criteria
     *
     * @return array<string, mixed>
     */
    public function provide(array $criteria = []): array;
}
