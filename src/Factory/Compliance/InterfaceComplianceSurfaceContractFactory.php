<?php

declare(strict_types=1);

namespace App\Interfacing\Factory\Compliance;

use App\Interfacing\Contract\Surface\InterfaceComplianceSurfaceContract;

final class InterfaceComplianceSurfaceContractFactory
{
    /**
     * @param array<string, mixed> $showcase
     */
    public function create(array $showcase = []): InterfaceComplianceSurfaceContract
    {
        return new InterfaceComplianceSurfaceContract(
            InterfaceComplianceSurfaceContract::WORD,
            InterfaceComplianceSurfaceContract::VIEW_INDEX,
            'compliance/index.html.twig',
            $this->slotMap(),
            [
                'title' => 'Compliance',
                'eyebrow' => 'Governance',
                'summary' => 'Canonical compliance surface rendered from the compliance business word.',
            ] + $this->normalizeShowcase($showcase),
            [
                'top.search' => [
                    'action' => '/interfacing/surface/compliance',
                    'method' => 'GET',
                    'queryName' => 'q',
                    'placeholder' => 'Search compliance rules, checks, and obligations...',
                    'query' => is_scalar($showcase['query'] ?? null) ? (string) $showcase['query'] : '',
                ],
                'left.panel' => [
                    'items' => [
                        ['title' => 'Compliance rules', 'href' => '/interfacing/surface/compliance-rule/'],
                        ['title' => 'Compliance checks', 'href' => '/interfacing/surface/compliance-check/'],
                        ['title' => 'Obligations', 'href' => '/obligation/'],
                    ],
                ],
                'main.body' => [
                    'sections' => [
                        [
                            'title' => 'Governance overview',
                            'summary' => 'Core compliance controls and checks.',
                            'cards' => [
                                ['eyebrow' => 'Rules', 'title' => 'Rules', 'summary' => 'Defined compliance rulesets.', 'href' => '/interfacing/surface/compliance-rule/'],
                                ['eyebrow' => 'Checks', 'title' => 'Checks', 'summary' => 'Validation and control checks.', 'href' => '/interfacing/surface/compliance-check/'],
                                ['eyebrow' => 'Obligations', 'title' => 'Obligations', 'summary' => 'Tracked obligations and tasks.', 'href' => '/obligation/'],
                            ],
                        ],
                    ],
                ],
                'right.panel' => [
                    'stats' => [
                        ['label' => 'Rules', 'value' => '3'],
                        ['label' => 'Checks', 'value' => '3'],
                        ['label' => 'Obligations', 'value' => '3'],
                    ],
                ],
            ],
        );
    }

    /**
     * @return array<string, string>
     */
    private function slotMap(): array
    {
        return [
            'top.search' => 'Search',
            'left.panel' => 'Related',
            'main.body' => 'Overview',
            'right.panel' => 'Stats',
        ];
    }

    /**
     * @param array<string, mixed> $showcase
     *
     * @return array<string, mixed>
     */
    private function normalizeShowcase(array $showcase): array
    {
        $normalized = [];

        foreach (['query'] as $key) {
            if (array_key_exists($key, $showcase) && is_scalar($showcase[$key])) {
                $normalized[$key] = (string) $showcase[$key];
            }
        }

        return $normalized;
    }
}
