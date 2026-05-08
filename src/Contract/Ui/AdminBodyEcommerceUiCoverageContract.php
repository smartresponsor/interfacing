<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Ui;

/**
 * Canonical ecosystem/e-commerce UI coverage map for provider adoption.
 *
 * This contract prevents local agents from treating a single repository scan as
 * the whole product. Interfacing owns the provider UI contract and knows the
 * expected ecosystem page families that consumer components must eventually
 * expose through canonical providers.
 */
final readonly class AdminBodyEcommerceUiCoverageContract
{
    public const CONTRACT_DOC = 'docs/interfacing/interfacing-ecosystem-ecommerce-ui-coverage.md';
    public const AUDIT_ENTRYPOINT = 'tools/interfacing/admin-body-ecosystem-ui-coverage-audit.php';
    public const AUDIT_WRAPPER = 'tools/interfacing/admin-body-ecosystem-ui-coverage-audit.ps1';

    public const PRIMARY_PROVIDER = AdminBodyUiProviderCanonContract::PRIMARY_PROVIDER;
    public const SECONDARY_PROVIDER = AdminBodyUiProviderCanonContract::SECONDARY_PROVIDER;

    /** @return list<string> */
    public static function canonicalComponents(): array
    {
        return [
            'App',
            'Interfacing',
            'Cruding',
            'Objecting',
            'Cataloging',
            'Tagging',
            'Paging',
            'Vendoring',
            'Ordering',
            'Paying',
            'Shipping',
            'Taxating',
            'Currencing',
            'Messaging',
            'Locating',
            'Indexing',
        ];
    }

    /** @return list<string> */
    public static function ecommercePageFamilies(): array
    {
        return [
            'admin-dashboard',
            'catalog-management',
            'category-management',
            'product-management',
            'tag-management',
            'vendor-management',
            'order-management',
            'payment-management',
            'refund-management',
            'shipping-fulfillment',
            'tax-configuration',
            'currency-configuration',
            'message-center',
            'location-management',
            'search-index-management',
            'public-storefront',
            'cart-checkout',
            'customer-account',
        ];
    }

    /** @return array<string,list<string>> */
    public static function componentPageCoverage(): array
    {
        return [
            'Interfacing' => ['admin-dashboard', 'provider-shell', 'provider-body-contract', 'screen-directory'],
            'Cruding' => ['catalog-management', 'category-management', 'product-management', 'generic-resource-crud'],
            'Objecting' => ['object-field-pack', 'title-field-management', 'metadata-management'],
            'Cataloging' => ['catalog-management', 'category-management', 'product-management', 'public-storefront'],
            'Tagging' => ['tag-management', 'taxonomy-management'],
            'Paging' => ['page-management', 'public-page-preview'],
            'Vendoring' => ['vendor-management', 'vendor-payout-management'],
            'Ordering' => ['order-management', 'cart-checkout', 'customer-order-history'],
            'Paying' => ['payment-management', 'refund-management', 'payment-provider-operations'],
            'Shipping' => ['shipping-fulfillment', 'shipment-tracking', 'shipping-rate-management'],
            'Taxating' => ['tax-configuration', 'sales-tax-vat-rules'],
            'Currencing' => ['currency-configuration', 'money-formatting-management'],
            'Messaging' => ['message-center', 'notification-inbox', 'customer-vendor-threads'],
            'Locating' => ['location-management', 'address-management', 'service-area-management'],
            'Indexing' => ['search-index-management', 'search-diagnostics'],
            'App' => ['hosthub-home', 'admin-dashboard', 'public-storefront'],
        ];
    }
}
