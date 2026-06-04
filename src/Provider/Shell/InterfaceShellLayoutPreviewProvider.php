<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Shell;

use App\Interfacing\ProviderInterface\Shell\InterfaceShellChromeProviderInterface;
use App\Interfacing\ProviderInterface\Shell\InterfaceShellLayoutPreviewProviderInterface;

final readonly class InterfaceShellLayoutPreviewProvider implements InterfaceShellLayoutPreviewProviderInterface
{
    public function __construct(
        private InterfaceShellChromeProviderInterface $shellChromeProvider,
    ) {
    }

    /**
     * @return array<string,mixed>
     */
    public function preview(?string $activeId = null): array
    {
        $shell = $this->shellChromeProvider->provide($activeId ?? 'shell.layout.preview');
        $topLinks = $shell['topLink'] ?? [];
        $navigationLocations = is_array($shell['navigation']['locations'] ?? null) ? $shell['navigation']['locations'] : [];
        $rightGroups = $shell['rightPanelGroup'] ?? [];
        $footerGroups = $shell['footerGroup'] ?? [];
        $knownCrudResources = $shell['knownCrudResources'] ?? [];

        return [
            'schema' => 'smart-responsor.interfacing.shell-layout-preview.v1',
            'activeId' => $activeId ?? 'shell.layout.preview',
            'summary' => [
                'supportedModes' => 2,
                'requiredPanels' => 5,
                'topLinks' => count($topLinks),
                'primaryGroups' => count($navigationLocations['shell.left.middle'] ?? []),
                'sectionGroups' => count($navigationLocations['shell.context.middle'] ?? []),
                'rightGroups' => count($rightGroups),
                'footerGroups' => count($footerGroups),
                'knownCrudResources' => count($knownCrudResources),
            ],
            'modes' => [
                [
                    'id' => 'four-column',
                    'title' => 'Standard four-column shell',
                    'columns' => ['left', 'context', 'main', 'right'],
                    'topPanelRequired' => true,
                    'footerRequired' => true,
                    'rightPanelEnabled' => true,
                    'cssGrid' => '260px 220px minmax(0, 1fr) 280px',
                    'useCase' => 'Default admin/workbench mode for CRUD, diagnostics, application dashboards and navigation maps.',
                ],
                [
                    'id' => 'three-column',
                    'title' => 'Compact three-column shell',
                    'columns' => ['left', 'context', 'main'],
                    'topPanelRequired' => true,
                    'footerRequired' => true,
                    'rightPanelEnabled' => false,
                    'cssGrid' => '260px 220px minmax(0, 1fr)',
                    'useCase' => 'Allowed only when a page explicitly disables the right context panel; Top and Footer remain mandatory.',
                ],
            ],
            'slots' => [
                ['id' => 'header', 'title' => 'Header', 'required' => true, 'source' => 'shell.header.* / shell.topLink', 'count' => count($topLinks)],
                ['id' => 'left', 'title' => 'Left panel', 'required' => true, 'source' => 'shell.navigation.locations.shell.left.middle', 'count' => count($navigationLocations['shell.left.middle'] ?? [])],
                ['id' => 'context', 'title' => 'Context panel', 'required' => true, 'source' => 'shell.navigation.locations.shell.context.middle', 'count' => count($navigationLocations['shell.context.middle'] ?? [])],
                ['id' => 'main', 'title' => 'Main', 'required' => true, 'source' => 'Twig body block / shell.main.content', 'count' => 1],
                ['id' => 'right', 'title' => 'Right panel', 'required' => true, 'source' => 'shell.rightPanelGroup', 'count' => count($rightGroups)],
                ['id' => 'footer', 'title' => 'Footer', 'required' => true, 'source' => 'shell.footerGroup', 'count' => count($footerGroups)],
            ],
            'contract' => [
                'headerAndFooterAlwaysRequired' => true,
                'defaultMode' => 'four-column',
                'compactMode' => 'three-column',
                'compactModeRule' => 'Only right may be disabled; Header, left, context, main and footer must remain present.',
                'crudVisibilityRule' => 'Known connected, canonical and planned Smart Responsor resources must remain visible through shell navigation and application dashboards.',
            ],
        ];
    }
}
