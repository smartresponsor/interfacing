<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Ecommerce;

use App\Interfacing\Contract\View\EcommerceComponentRoadmapItem;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceComponentRoadmapProviderInterface;

final readonly class EcommerceComponentRoadmapProvider implements EcommerceComponentRoadmapProviderInterface
{
    public function provide(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $items = [];
        foreach ($this->rows() as $row) {
            $items[] = new EcommerceComponentRoadmapItem(
                id: $row['id'],
                zone: $row['zone'],
                component: $row['component'],
                status: $row['status'],
                primaryUrl: $row['primaryUrl'],
                ownership: $row['ownership'],
                screen: $row['screen'],
                resource: $row['resource'],
                note: $row['note'],
            );
        }

        usort(
            $items,
            static fn (EcommerceComponentRoadmapItem $left, EcommerceComponentRoadmapItem $right): int => [
                self::zoneOrder($left->zone()),
                self::statusOrder($left->status()),
                $left->component(),
            ] <=> [
                self::zoneOrder($right->zone()),
                self::statusOrder($right->status()),
                $right->component(),
            ],
        );

        return $cache = $items;
    }

    public function groupedByZone(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $grouped = [];
        foreach ($this->provide() as $item) {
            $grouped[$item->zone()][] = $item;
        }

        return $cache = $grouped;
    }

    public function statusCounts(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        $counts = ['connected' => 0, 'canonical' => 0, 'planned' => 0, 'total' => 0];
        foreach ($this->provide() as $item) {
            ++$counts['total'];
            ++$counts[$item->status()];
        }

        return $cache = $counts;
    }

    /** @return list<array{id:string,zone:string,component:string,status:string,primaryUrl:string,ownership:string,screen:list<string>,resource:list<string>,note:string}> */
    private function rows(): array
    {
        return [
            $this->row('accessing', 'Access', 'Accessing', 'canonical', '/account/', 'Accessing owns users, roles, sessions and security events.', ['Accounts', 'Operator accounts', 'Roles and permissions', 'Sessions', 'Security events', 'Invitations'], ['account', 'role', 'permission', 'session', 'security-event', 'invitation']),
            $this->row('cataloging', 'Catalog and discovery', 'Cataloging', 'connected', '/category/', 'Cataloging owns catalog records and fixtures; Interfacing owns only chrome and CRUD links.', ['Products', 'Categories', 'Collections', 'Attributes', 'Media references', 'Catalog search preview'], ['product', 'category', 'collection', 'attribute', 'catalog-media']),
            $this->row('faceting', 'Catalog and discovery', 'Faceting', 'planned', '/facet/', 'Faceting owns facet definitions and filter vocabularies.', ['Facet groups', 'Facet values', 'Filter preview'], ['facet', 'facet-value', 'facet-group']),
            $this->row('tagging', 'Catalog and discovery', 'Tagging', 'planned', '/tag/', 'Tagging owns tags and tag assignments.', ['Tags', 'Tag assignments', 'Tag usage'], ['tag', 'tag-assignment']),
            $this->row('search', 'Catalog and discovery', 'Search', 'planned', '/search-query/', 'Search owns query surfaces and search result diagnostics.', ['Search queries', 'Search results', 'Search tuning'], ['search-query', 'search-result']),
            $this->row('indexing', 'Catalog and discovery', 'Indexing', 'planned', '/index-job/', 'Indexing owns index jobs, snapshots and rebuild status.', ['Index jobs', 'Index snapshots', 'Rebuild monitor'], ['index-job', 'index-snapshot']),
            $this->row('discovering', 'Catalog and discovery', 'Discovering', 'planned', '/discovery-rule/', 'Discovering owns recommendation/discovery rules.', ['Discovery rules', 'Discovery placements'], ['discovery-rule', 'discovery-placement']),
            $this->row('commercializing', 'Commercial and retail', 'Commercializing', 'planned', '/offer/', 'Commercializing owns offers, campaigns and commercial visibility.', ['Offers', 'Promotions', 'Campaigns'], ['offer', 'promotion', 'campaign']),
            $this->row('retailing', 'Commercial and retail', 'Retailing', 'planned', '/retail-offer/', 'Retailing owns storefront-facing retail offer surfaces.', ['Retail offers', 'Price books', 'Storefront listings'], ['retail-offer', 'price-book', 'listing']),
            $this->row('ordering', 'Ordering', 'Ordering', 'connected', '/order/', 'Ordering owns carts, orders, order items and status workflow.', ['Orders', 'Order items', 'Carts', 'Checkout sessions', 'Returns', 'Cancellations'], ['order', 'order-item', 'cart', 'checkout-session', 'return', 'cancellation']),
            $this->row('consuming', 'Ordering', 'Consuming', 'planned', '/consumer/', 'Consuming owns customer/consumer-facing account and behavior records.', ['Consumers', 'Consumer profiles', 'Consumer activity'], ['consumer', 'consumer-profile']),
            $this->row('billing', 'Billing and paying', 'Billing', 'connected', '/invoice/', 'Billing owns invoices, meters, statements and billing evidence.', ['Invoices', 'Billing meters', 'Statements', 'Ledger entries'], ['invoice', 'billing-meter', 'statement', 'ledger-entry']),
            $this->row('paying', 'Billing and paying', 'Paying', 'planned', '/payment/', 'Paying owns payment attempts, refunds and payout-facing flows.', ['Payments', 'Payment attempts', 'Refunds', 'Payouts'], ['payment', 'payment-attempt', 'refund', 'payout']),
            $this->row('currencing', 'Billing and paying', 'Currencing', 'canonical', '/currency/', 'Currencing owns ISO currency codes, minor units, formatting metadata and money normalization for commerce surfaces.', ['Currencies', 'Currency metadata', 'Minor units', 'Money formats', 'Money normalization'], ['currency', 'currency-metadata', 'currency-minor-unit', 'money-format', 'money-normalization']),
            $this->row('exchanging', 'Billing and paying', 'Exchanging', 'canonical', '/exchange-rate/', 'Exchanging owns exchange rates, currency pairs, conversion quotes and conversion rule policy.', ['Exchange rates', 'Exchange pairs', 'Exchange quotes', 'Conversion rules', 'Rate providers'], ['exchange-rate', 'exchange-pair', 'exchange-quote', 'conversion-rule', 'rate-provider']),
            $this->row('subscripting', 'Billing and paying', 'Subscripting', 'canonical', '/subscription/', 'Subscripting owns subscriptions, plans, prices, entitlements and recurring lifecycle events.', ['Subscriptions', 'Subscription plans', 'Subscription prices', 'Entitlements', 'Billing cycles', 'Lifecycle events'], ['subscription', 'subscription-plan', 'subscription-price', 'subscription-entitlement', 'billing-cycle', 'subscription-event']),
            $this->row('commissioning', 'Billing and paying', 'Commissioning', 'canonical', '/commission-plan/', 'Commissioning owns commission plans, rules, agreements, accruals, payouts and statements for partner revenue workflows.', ['Commission plans', 'Commission rules', 'Agreements', 'Accruals', 'Payouts', 'Statements'], ['commission-plan', 'commission-rule', 'commission-agreement', 'commission-accrual', 'commission-payout', 'commission-statement']),
            $this->row('taxating', 'Tax and governance', 'Taxating', 'canonical', '/taxation-api/', 'Taxating owns tax rates, zones, product taxation and tax evidence.', ['Taxation API', 'Tax rates', 'Tax zones', 'Product taxation', 'Calculation preview'], ['taxation-api', 'tax-rate', 'tax-zone', 'product-taxation', 'tax-evidence']),
            $this->row('complying', 'Tax and governance', 'Complying', 'planned', '/compliance-rule/', 'Complying owns policy/compliance checks and obligations.', ['Compliance rules', 'Compliance checks', 'Obligations'], ['compliance-rule', 'compliance-check', 'obligation']),
            $this->row('governancing', 'Tax and governance', 'Governancing', 'planned', '/governance-policy/', 'Governancing owns governance policies and approval surfaces.', ['Governance policies', 'Approvals', 'Decision log'], ['governance-policy', 'approval', 'decision']),
            $this->row('adjudicating', 'Tax and governance', 'Adjudicating', 'planned', '/adjudication-case/', 'Adjudicating owns dispute/adjudication case screens.', ['Adjudication cases', 'Case evidence', 'Case decisions'], ['adjudication-case', 'case-evidence', 'case-decision']),
            $this->row('evaluating', 'Tax and governance', 'Evaluating', 'planned', '/evaluation/', 'Evaluating owns scoring and assessment surfaces.', ['Evaluations', 'Scores', 'Review outcomes'], ['evaluation', 'score', 'review-outcome']),
            $this->row('facting', 'Tax and governance', 'Facting', 'planned', '/fact/', 'Facting owns fact records and evidence assertions.', ['Facts', 'Fact sources', 'Evidence links'], ['fact', 'fact-source', 'evidence-link']),
            $this->row('shipping', 'Fulfillment and location', 'Shipping', 'planned', '/shipment/', 'Shipping owns shipments, labels, carriers and tracking events.', ['Shipments', 'Shipment items', 'Carriers', 'Rates', 'Labels', 'Tracking events'], ['shipment', 'shipment-item', 'carrier', 'shipping-rate', 'label', 'tracking-event']),
            $this->row('addressing', 'Fulfillment and location', 'Addressing', 'planned', '/address/', 'Addressing owns address books, validation and normalized address records.', ['Addresses', 'Address validation', 'Address book'], ['address', 'address-validation', 'address-book']),
            $this->row('locating', 'Fulfillment and location', 'Locating', 'planned', '/location/', 'Locating owns locations, zones and geographical resolution.', ['Locations', 'Location zones', 'Geo resolution'], ['location', 'location-zone', 'geo-resolution']),
            $this->row('messaging', 'Messaging', 'Messaging', 'connected', '/message/', 'Messaging owns rooms, threads, messages and notification fixtures.', ['Notifications inbox', 'Rooms', 'Threads', 'Messages', 'Digests', 'Templates'], ['message', 'room', 'thread', 'digest', 'message-template']),
            $this->row('documenting', 'Documents and attachments', 'Documenting', 'planned', '/document/', 'Documenting owns generated documents and portal/documentation surfaces.', ['Documents', 'Generated files', 'Article/document portal'], ['document', 'generated-document', 'article']),
            $this->row('attaching', 'Documents and attachments', 'Attaching', 'planned', '/attachment/', 'Attaching owns binary/file references and attachment metadata.', ['Attachments', 'Media library', 'Attachment links'], ['attachment', 'media', 'attachment-link']),
            $this->row('vendoring', 'Platform operations', 'Vendoring', 'canonical', '/vendor/', 'Vendoring owns vendors, onboarding, statements and payout-facing vendor data.', ['Vendors', 'Vendor profiles', 'Vendor onboarding', 'Vendor statements'], ['vendor', 'vendor-profile', 'vendor-onboarding', 'vendor-statement']),
            $this->row('applicating', 'Platform operations', 'Applicating', 'canonical', '/application/', 'Applicating owns applications, approvals and submission flows.', ['Applications', 'Application reviews', 'Approvals'], ['application', 'application-review', 'approval']),
            $this->row('bridging', 'Platform operations', 'Bridging', 'planned', '/bridge/', 'Bridging owns integration bridges and external-system links.', ['Bridges', 'Bridge mappings', 'Integration health'], ['bridge', 'bridge-mapping', 'integration-health']),
            $this->row('harvesting', 'Platform operations', 'Harvesting', 'planned', '/harvest/', 'Harvesting owns ingestion/harvest jobs and imported source status.', ['Harvest jobs', 'Harvest sources', 'Import results'], ['harvest', 'harvest-source', 'import-result']),
            $this->row('runtiming', 'Platform operations', 'Runtiming', 'planned', '/runtime-node/', 'Runtiming owns runtime nodes and runtime health surfaces.', ['Runtime nodes', 'Runtime health', 'Runtime events'], ['runtime-node', 'runtime-event']),
            $this->row('rolling', 'Platform operations', 'Rolling', 'planned', '/rollout/', 'Rolling owns rollouts, rollout windows and release state.', ['Rollouts', 'Release windows', 'Release state'], ['rollout', 'release-window', 'release-state']),
            $this->row('projecting', 'Platform operations', 'Projecting', 'planned', '/projection/', 'Projecting owns projections and read-model update state.', ['Projections', 'Projection runs', 'Read model state'], ['projection', 'projection-run', 'read-model-state']),
            $this->row('analysing', 'Platform operations', 'Analysing', 'planned', '/analysis/', 'Analysing owns analysis jobs and operator-visible insights.', ['Analyses', 'Analysis jobs', 'Insights'], ['analysis', 'analysis-job', 'insight']),
            $this->row('anchoring', 'Platform operations', 'Anchoring', 'planned', '/anchor/', 'Anchoring owns anchors, references and stable linking records.', ['Anchors', 'Anchor references', 'Link checks'], ['anchor', 'anchor-reference', 'link-check']),
        ];
    }

    /** @return array{id:string,zone:string,component:string,status:string,primaryUrl:string,ownership:string,screen:list<string>,resource:list<string>,note:string} */
    private function row(string $id, string $zone, string $component, string $status, string $primaryUrl, string $ownership, array $screen, array $resource): array
    {
        return [
            'id' => $id,
            'zone' => $zone,
            'component' => $component,
            'status' => $status,
            'primaryUrl' => $primaryUrl,
            'ownership' => $ownership,
            'screen' => $screen,
            'resource' => $resource,
            'note' => sprintf('%s must provide fixtures/providers; Interfacing renders shell, navigation and CRUD affordances only.', $component),
        ];
    }

    private static function zoneOrder(string $zone): int
    {
        return match ($zone) {
            'Access' => 10,
            'Catalog and discovery' => 20,
            'Commercial and retail' => 30,
            'Ordering' => 40,
            'Billing and paying' => 50,
            'Tax and governance' => 60,
            'Fulfillment and location' => 70,
            'Messaging' => 80,
            'Documents and attachments' => 90,
            'Platform operations' => 100,
            default => 900,
        };
    }

    private static function statusOrder(string $status): int
    {
        return match ($status) {
            'connected' => 10,
            'canonical' => 20,
            'planned' => 30,
            default => 900,
        };
    }
}
