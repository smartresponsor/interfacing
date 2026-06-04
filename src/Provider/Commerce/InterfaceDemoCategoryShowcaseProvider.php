<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Commerce;

use App\Interfacing\ProviderInterface\Commerce\InterfaceCategoryShowcaseProviderInterface;

/**
 * Demo-backed storefront surface for Catalog Category routes.
 *
 * Temporary category data lives in the provider, not in Twig. Cataloging can
 * later replace this provider with real category, merchandising, and product
 * count records while keeping the storefront template contract intact.
 */
final readonly class InterfaceDemoCategoryShowcaseProvider implements InterfaceCategoryShowcaseProviderInterface
{
    public function provide(array $criteria = []): array
    {
        $query = isset($criteria['q']) && is_string($criteria['q']) ? trim($criteria['q']) : '';
        $section = isset($criteria['section']) && is_string($criteria['section']) ? trim($criteria['section']) : 'all';
        $cards = $this->filterCards($this->cards(), $query, $section);

        return [
            'id' => 'catalog.category.storefront',
            'title' => 'Categories',
            'eyebrow' => 'Catalog storefront',
            'summary' => 'Customer-facing category browsing prepared for real Cataloging records. Demo categories are supplied by a provider, not by Twig hardcode.',
            'route' => '/interfacing/showcase/catalog/category',
            'canonicalRoutes' => ['/interfacing/showcase/catalog/category', '/interfacing/showcase/category'],
            'query' => $query,
            'activeSection' => $section,
            'filters' => $this->filters(),
            'stats' => [
                ['label' => 'Categories', 'value' => (string) count($cards)],
                ['label' => 'Sections', 'value' => '4'],
                ['label' => 'Source', 'value' => 'Demo provider'],
            ],
            'heroActions' => [
                ['title' => 'Browse departments', 'url' => '#shopping-departments', 'primary' => true],
                ['title' => 'View featured', 'url' => '#featured-categories', 'primary' => false],
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
            ['id' => 'all', 'title' => 'All categories', 'url' => '/interfacing/showcase/catalog/category'],
            ['id' => 'featured', 'title' => 'Featured categories', 'url' => '/interfacing/showcase/catalog/category?section=featured'],
            ['id' => 'department', 'title' => 'Departments', 'url' => '/interfacing/showcase/catalog/category?section=department'],
            ['id' => 'commerce', 'title' => 'Commerce categories', 'url' => '/interfacing/showcase/catalog/category?section=commerce'],
            ['id' => 'intelligence', 'title' => 'Intelligence categories', 'url' => '/interfacing/showcase/catalog/category?section=intelligence'],
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
            $this->section('featured-categories', 'Featured categories', 'Top-level storefront categories for first customer orientation.', $this->cardsByGroup($cards, 'featured')),
            $this->section('shopping-departments', 'Shopping departments', 'Department-style categories that can later be backed by Cataloging records.', $this->cardsByGroup($cards, 'department')),
            $this->section('commerce-categories', 'Commerce categories', 'Business categories that group catalog, order, payment, shipment, and subscription experiences.', $this->cardsByGroup($cards, 'commerce')),
            $this->section('intelligence-categories', 'Intelligence categories', 'Knowledge and automation categories prepared for project-like intellectual products.', $this->cardsByGroup($cards, 'intelligence')),
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
    private function cardsByGroup(array $cards, string $group): array
    {
        return array_values(array_filter($cards, static function (array $card) use ($group): bool {
            $groups = $card['groups'] ?? [];

            return is_array($groups) && in_array($group, $groups, true);
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
                $groups = $card['groups'] ?? [];
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
                $card['status'] ?? '',
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
                'id' => 'category-commerce-suite',
                'title' => 'Commerce suite',
                'eyebrow' => 'Featured category',
                'summary' => 'A storefront entry for catalog, cart, order, payment, shipment, and taxation workflows.',
                'status' => 'Featured',
                'itemCount' => '18 product groups',
                'href' => '/interfacing/showcase/product?section=top',
                'visual' => 'Commerce',
                'tags' => ['Catalog', 'Orders', 'Payments'],
                'groups' => ['featured', 'department', 'commerce'],
            ],
            [
                'id' => 'category-catalog-shelves',
                'title' => 'Catalog shelves',
                'eyebrow' => 'Department',
                'summary' => 'Product browsing lanes, category shelves, collection cards, and merchandising surfaces.',
                'status' => 'Ready for records',
                'itemCount' => '12 shelves',
                'href' => '/interfacing/showcase/catalog/product',
                'visual' => 'Catalog',
                'tags' => ['Products', 'Categories'],
                'groups' => ['featured', 'department', 'commerce'],
            ],
            [
                'id' => 'category-digital-automation',
                'title' => 'Digital automation',
                'eyebrow' => 'Intellectual category',
                'summary' => 'AI automation packs, workflow templates, tool-driven operations, and smart response kits.',
                'status' => 'Preview',
                'itemCount' => '9 concepts',
                'href' => '/interfacing/showcase/product?section=intelligence',
                'visual' => 'Automation',
                'tags' => ['AI automation', 'Tools'],
                'groups' => ['featured', 'intelligence'],
            ],
            [
                'id' => 'category-project-products',
                'title' => 'Project products',
                'eyebrow' => 'Projecting category',
                'summary' => 'Intellectual product categories for project packages, templates, and owner-facing deliverables.',
                'status' => 'Concept',
                'itemCount' => '7 project cards',
                'href' => '/interfacing/showcase/project',
                'visual' => 'Projects',
                'tags' => ['Projects', 'Knowledge'],
                'groups' => ['intelligence', 'department'],
            ],
            [
                'id' => 'category-finance-commerce',
                'title' => 'Finance commerce',
                'eyebrow' => 'Business category',
                'summary' => 'Billing, subscription, currency, exchange-rate, commission, and tax-aware commerce.',
                'status' => 'Business ready',
                'itemCount' => '14 finance flows',
                'href' => '/subscription/',
                'visual' => 'Finance',
                'tags' => ['Billing', 'Currency', 'Taxation'],
                'groups' => ['commerce', 'department'],
            ],
            [
                'id' => 'category-customer-communication',
                'title' => 'Customer communication',
                'eyebrow' => 'Messaging category',
                'summary' => 'Inbox, outbox, compose, notifications, rooms, chats, and searchable message activity.',
                'status' => 'Connected shell',
                'itemCount' => '8 message surfaces',
                'href' => '/interfacing/showcase/message/compose',
                'visual' => 'Messaging',
                'tags' => ['Messaging', 'Notifications'],
                'groups' => ['featured', 'department'],
            ],
        ];
    }
}
