<?php

declare(strict_types=1);

namespace App\Interfacing\Factory\Commerce;

use App\Interfacing\Contract\Surface\InterfaceProductSurfaceContract;

final class InterfaceProductSurfaceContractFactory
{
    /**
     * @param array<string, mixed> $showcase
     */
    public function create(array $showcase): InterfaceProductSurfaceContract
    {
        $sections = $this->normalizeSections($showcase['sections'] ?? []);
        $stats = $this->normalizeStats($showcase['stats'] ?? []);
        $filters = $this->normalizeFilters($showcase['filters'] ?? []);
        $heroActions = $this->normalizeActions($showcase['heroActions'] ?? []);
        $cards = $this->normalizeCards($showcase['cards'] ?? []);

        return new InterfaceProductSurfaceContract(
            InterfaceProductSurfaceContract::WORD,
            InterfaceProductSurfaceContract::VIEW_INDEX,
            'product/index.html.twig',
            $this->slotMap(),
            [
                'id' => is_scalar($showcase['id'] ?? null) ? (string) $showcase['id'] : 'product.storefront',
                'title' => is_scalar($showcase['title'] ?? null) ? (string) $showcase['title'] : 'Products',
                'eyebrow' => is_scalar($showcase['eyebrow'] ?? null) ? (string) $showcase['eyebrow'] : 'Storefront',
                'summary' => is_scalar($showcase['summary'] ?? null) ? (string) $showcase['summary'] : 'Product storefront',
                'route' => is_scalar($showcase['route'] ?? null) ? (string) $showcase['route'] : '/interfacing/showcase/product',
                'query' => is_scalar($showcase['query'] ?? null) ? (string) $showcase['query'] : '',
                'activeSection' => is_scalar($showcase['activeSection'] ?? null) ? (string) $showcase['activeSection'] : 'all',
                'canonicalRoutes' => $this->normalizeList($showcase['canonicalRoutes'] ?? []),
            ],
            [
                'top.search' => [
                    'action' => is_scalar($showcase['route'] ?? null) ? (string) $showcase['route'] : '/interfacing/showcase/product',
                    'method' => 'GET',
                    'queryName' => 'q',
                    'placeholder' => 'Search products, categories, tags...',
                    'query' => is_scalar($showcase['query'] ?? null) ? (string) $showcase['query'] : '',
                ],
                'left.panel' => [
                    'filters' => $filters,
                ],
                'main.body' => [
                    'sections' => $sections,
                    'cards' => $cards,
                ],
                'right.panel' => [
                    'stats' => $stats,
                    'actions' => $heroActions,
                ],
            ],
        );
    }

    /**
     * @return list<array{id: string, title: string, summary: string, cards: list<array<string, mixed>>}>
     */
    private function normalizeSections(mixed $sections): array
    {
        if (!is_array($sections)) {
            return [];
        }

        $normalized = [];
        foreach ($sections as $section) {
            if (!is_array($section)) {
                continue;
            }

            $normalized[] = [
                'id' => is_scalar($section['id'] ?? null) ? (string) $section['id'] : 'section',
                'title' => is_scalar($section['title'] ?? null) ? (string) $section['title'] : 'Section',
                'summary' => is_scalar($section['summary'] ?? null) ? (string) $section['summary'] : '',
                'cards' => $this->normalizeCards($section['cards'] ?? []),
            ];
        }

        return $normalized;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function normalizeCards(mixed $cards): array
    {
        if (!is_array($cards)) {
            return [];
        }

        $normalized = [];
        foreach ($cards as $card) {
            if (!is_array($card)) {
                continue;
            }

            $normalized[] = [
                'id' => is_scalar($card['id'] ?? null) ? (string) $card['id'] : 'product-card',
                'title' => is_scalar($card['title'] ?? null) ? (string) $card['title'] : 'Product',
                'eyebrow' => is_scalar($card['eyebrow'] ?? null) ? (string) $card['eyebrow'] : 'Product',
                'summary' => is_scalar($card['summary'] ?? null) ? (string) $card['summary'] : '',
                'price' => is_scalar($card['price'] ?? null) ? (string) $card['price'] : '',
                'href' => is_scalar($card['href'] ?? null) ? (string) $card['href'] : '#',
                'status' => is_scalar($card['status'] ?? null) ? (string) $card['status'] : '',
                'visual' => is_scalar($card['visual'] ?? null) ? (string) $card['visual'] : '',
                'tags' => $this->normalizeList($card['tags'] ?? []),
                'merchandising' => $this->normalizeList($card['merchandising'] ?? []),
            ];
        }

        return $normalized;
    }

    /**
     * @return list<array{title: string, url: string, primary?: bool}>
     */
    private function normalizeActions(mixed $actions): array
    {
        if (!is_array($actions)) {
            return [];
        }

        $normalized = [];
        foreach ($actions as $action) {
            if (!is_array($action)) {
                continue;
            }

            $normalized[] = [
                'title' => is_scalar($action['title'] ?? null) ? (string) $action['title'] : 'Open',
                'url' => is_scalar($action['url'] ?? null) ? (string) $action['url'] : '#',
                'primary' => (bool) ($action['primary'] ?? false),
            ];
        }

        return $normalized;
    }

    /**
     * @return list<array{id: string, title: string, url: string}>
     */
    private function normalizeFilters(mixed $filters): array
    {
        if (!is_array($filters)) {
            return [];
        }

        $normalized = [];
        foreach ($filters as $filter) {
            if (!is_array($filter)) {
                continue;
            }

            $normalized[] = [
                'id' => is_scalar($filter['id'] ?? null) ? (string) $filter['id'] : 'filter',
                'title' => is_scalar($filter['title'] ?? null) ? (string) $filter['title'] : 'Filter',
                'url' => is_scalar($filter['url'] ?? null) ? (string) $filter['url'] : '#',
            ];
        }

        return $normalized;
    }

    /**
     * @return list<array{label: string, value: string}>
     */
    private function normalizeStats(mixed $stats): array
    {
        if (!is_array($stats)) {
            return [];
        }

        $normalized = [];
        foreach ($stats as $stat) {
            if (!is_array($stat)) {
                continue;
            }

            $normalized[] = [
                'label' => is_scalar($stat['label'] ?? null) ? (string) $stat['label'] : 'Stat',
                'value' => is_scalar($stat['value'] ?? null) ? (string) $stat['value'] : '0',
            ];
        }

        return $normalized;
    }

    /**
     * @return list<string>
     */
    private function normalizeList(mixed $values): array
    {
        if (!is_array($values)) {
            return [];
        }

        return array_values(array_filter(array_map(
            static fn (mixed $value): string => is_scalar($value) ? trim((string) $value) : '',
            $values
        ), static fn (string $value): bool => '' !== $value));
    }

    /**
     * @return array<string, string>
     */
    private function slotMap(): array
    {
        return [
            'top.search' => 'Search',
            'left.panel' => 'Filters',
            'main.body' => 'Sections',
            'right.panel' => 'Stats',
        ];
    }
}
