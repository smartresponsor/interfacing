<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Commerce;

use App\Interfacing\ProviderInterface\Commerce\InterfaceProductShowcaseProviderInterface;

/**
 * Demo-backed storefront surface for Product routes.
 *
 * The provider keeps temporary merchandising content outside Twig. The Twig
 * layer remains a storefront contract, while Cataloging/Producting can later
 * replace this provider with real product, price-profile, inventory, and
 * promotion records without rewriting the e-commerce page template.
 */
final readonly class InterfaceDemoProductShowcaseProvider implements InterfaceProductShowcaseProviderInterface
{
    public function provide(array $criteria = []): array
    {
        $query = isset($criteria['q']) && is_string($criteria['q']) ? trim($criteria['q']) : '';
        $section = isset($criteria['section']) && is_string($criteria['section']) ? trim($criteria['section']) : 'all';
        $cards = $this->filterCards($this->cards(), $query, $section);

        return [
            'id' => 'catalog.product.storefront',
            'title' => 'Products',
            'eyebrow' => 'E-commerce storefront',
            'summary' => 'A customer-facing product browsing page prepared for real Cataloging records and provider-owned price profiles. Demo content is supplied by a provider, not by Twig hardcode.',
            'route' => '/interfacing/showcase/product',
            'canonicalRoutes' => ['/interfacing/showcase/product', '/interfacing/showcase/catalog/product'],
            'query' => $query,
            'activeSection' => $section,
            'filters' => $this->filters(),
            'stats' => [
                ['label' => 'Products', 'value' => (string) count($cards)],
                ['label' => 'Sections', 'value' => '4'],
                ['label' => 'Source', 'value' => 'Demo provider'],
            ],
            'heroActions' => [
                ['title' => 'Shop top products', 'url' => '#top-products', 'primary' => true],
                ['title' => 'View discounts', 'url' => '#discount-products', 'primary' => false],
            ],
            'sections' => $this->sections($cards),
            'cards' => $cards,
        ];
    }

    /**
     * @return list<array{id:string,title:string,url:string}>
     */
    private function filters(): array
    {
        return [
            ['id' => 'all', 'title' => 'All products', 'url' => '/interfacing/showcase/product'],
            ['id' => 'top', 'title' => 'Top products', 'url' => '/interfacing/showcase/product?section=top'],
            ['id' => 'discount', 'title' => 'Discounts', 'url' => '/interfacing/showcase/product?section=discount'],
            ['id' => 'new', 'title' => 'New arrivals', 'url' => '/interfacing/showcase/product?section=new'],
            ['id' => 'intelligence', 'title' => 'Intellectual products', 'url' => '/interfacing/showcase/product?section=intelligence'],
        ];
    }

    /**
     * @param list<array<string, mixed>> $cards
     *
     * @return list<array<string, mixed>>
     */
    private function sections(array $cards): array
    {
        return array_values(array_filter([
            $this->section('top-products', 'Top products', 'Customer-ready storefront cards for first-page merchandising.', $this->cardsByMerchandising($cards, 'top')),
            $this->section('discount-products', 'Discount products', 'Products with provider-owned compare-at prices, savings, and promotion badges.', $this->cardsByMerchandising($cards, 'discount')),
            $this->section('new-products', 'New arrivals', 'Fresh cards that keep the product page populated before real fixtures land.', $this->cardsByMerchandising($cards, 'new')),
            $this->section('intellectual-products', 'Intellectual products', 'Knowledge and project-like products sharing the same storefront contract.', $this->cardsByMerchandising($cards, 'intelligence')),
        ], static fn (array $section): bool => [] !== $section['cards']));
    }

    /**
     * @param list<array<string, mixed>> $cards
     *
     * @return array{id:string,title:string,summary:string,cards:list<array<string,mixed>>}
     */
    private function section(string $id, string $title, string $summary, array $cards): array
    {
        return [
            'id' => $id,
            'title' => $title,
            'summary' => $summary,
            'cards' => $cards,
        ];
    }

    /**
     * @param list<array<string, mixed>> $cards
     *
     * @return list<array<string, mixed>>
     */
    private function cardsByMerchandising(array $cards, string $merchandising): array
    {
        return array_values(array_filter($cards, static function (array $card) use ($merchandising): bool {
            $groups = $card['merchandising'] ?? [];

            return is_array($groups) && in_array($merchandising, $groups, true);
        }));
    }

    /**
     * @param list<array<string, mixed>> $cards
     *
     * @return list<array<string, mixed>>
     */
    private function filterCards(array $cards, string $query, string $section): array
    {
        return array_values(array_filter($cards, static function (array $card) use ($query, $section): bool {
            if ('all' !== $section) {
                $groups = $card['merchandising'] ?? [];
                if (!is_array($groups) || !in_array($section, $groups, true)) {
                    return false;
                }
            }

            if ('' === $query) {
                return true;
            }

            $haystack = strtolower(implode(' ', array_filter([
                $card['title'] ?? '',
                $card['eyebrow'] ?? '',
                $card['summary'] ?? '',
                $card['category'] ?? '',
                implode(' ', is_array($card['tags'] ?? null) ? $card['tags'] : []),
            ], static fn (mixed $value): bool => is_string($value) && '' !== $value)));

            return str_contains($haystack, strtolower($query));
        }));
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function cards(): array
    {
        return [
            [
                'id' => 'product-commerce-command-center',
                'title' => 'Commerce Command Center',
                'eyebrow' => 'Top product',
                'category' => 'Commerce workspace',
                'summary' => 'Unified storefront card for catalog, cart, order, payment, and shipment workflows.',
                'price' => '$249',
                'oldPrice' => '$319',
                'priceNote' => 'starter workspace',
                'saving' => 'Save 22%',
                'status' => 'Top rated',
                'rating' => '4.9',
                'inventory' => '84 available',
                'accent' => 'Commerce',
                'visual' => 'Storefront suite',
                'href' => '#product-commerce-command-center',
                'tags' => ['Catalog', 'Orders', 'Payments'],
                'merchandising' => ['top', 'discount'],
            ],
            [
                'id' => 'product-catalog-shelf',
                'title' => 'Catalog Shelf',
                'eyebrow' => 'Product discovery',
                'category' => 'Cataloging',
                'summary' => 'Reusable listing card with category badges, price area, availability, and customer action affordance.',
                'price' => '$79',
                'oldPrice' => null,
                'priceNote' => 'per catalog lane',
                'saving' => null,
                'status' => 'Ready for data',
                'rating' => '4.7',
                'inventory' => 'In stock',
                'accent' => 'Catalog',
                'visual' => 'Catalog card',
                'href' => '#product-catalog-shelf',
                'tags' => ['Products', 'Categories'],
                'merchandising' => ['top', 'new'],
            ],
            [
                'id' => 'product-ai-workflow-pack',
                'title' => 'AI Workflow Pack',
                'eyebrow' => 'Automation product',
                'category' => 'Automation',
                'summary' => 'Intelligent bundle for prompts, tools, policy gates, and operator-ready AI tasks.',
                'price' => '$149',
                'oldPrice' => '$199',
                'priceNote' => 'workflow bundle',
                'saving' => 'Save $50',
                'status' => 'Deal',
                'rating' => '4.8',
                'inventory' => 'Limited preview',
                'accent' => 'Automation',
                'visual' => 'AI pack',
                'href' => '#product-ai-workflow-pack',
                'tags' => ['AI automation', 'Tools'],
                'merchandising' => ['discount', 'intelligence'],
            ],
            [
                'id' => 'product-project-intelligence',
                'title' => 'Project Intelligence',
                'eyebrow' => 'Intellectual product',
                'category' => 'Projecting',
                'summary' => 'Project-like knowledge product card reserved for future Projecting storefront surfaces.',
                'price' => '$399',
                'oldPrice' => null,
                'priceNote' => 'project package',
                'saving' => null,
                'status' => 'Concept',
                'rating' => '4.6',
                'inventory' => 'Template preview',
                'accent' => 'Projects',
                'visual' => 'Knowledge product',
                'href' => '#product-project-intelligence',
                'tags' => ['Projects', 'Knowledge'],
                'merchandising' => ['top', 'intelligence'],
            ],
            [
                'id' => 'product-subscription-suite',
                'title' => 'Subscription Suite',
                'eyebrow' => 'Recurring commerce',
                'category' => 'Billing',
                'summary' => 'Subscription plans, billing cycles, and customer entitlement preview in a compact card.',
                'price' => '$29',
                'oldPrice' => '$39',
                'priceNote' => 'monthly',
                'saving' => 'Intro price',
                'status' => 'Popular',
                'rating' => '4.5',
                'inventory' => 'Available',
                'accent' => 'Billing',
                'visual' => 'Subscription',
                'href' => '#product-subscription-suite',
                'tags' => ['Subscriptions', 'Billing'],
                'merchandising' => ['discount', 'new'],
            ],
            [
                'id' => 'product-global-selling-kit',
                'title' => 'Global Selling Kit',
                'eyebrow' => 'Currency and tax',
                'category' => 'Global commerce',
                'summary' => 'Currency, exchange-rate, taxation, and shipment-aware product commerce in one storefront card.',
                'price' => '$189',
                'oldPrice' => null,
                'priceNote' => 'commerce add-on',
                'saving' => null,
                'status' => 'New',
                'rating' => '4.7',
                'inventory' => 'Ready for integration',
                'accent' => 'Global',
                'visual' => 'Global kit',
                'href' => '#product-global-selling-kit',
                'tags' => ['Currency', 'Taxation', 'Shipping'],
                'merchandising' => ['new', 'top'],
            ],
        ];
    }
}
