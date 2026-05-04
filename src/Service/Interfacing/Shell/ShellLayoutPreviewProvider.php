<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Shell;

use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellChromeProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellLayoutPreviewProviderInterface;

final readonly class ShellLayoutPreviewProvider implements ShellLayoutPreviewProviderInterface
{
    public function __construct(
        private ShellChromeProviderInterface $shellChromeProvider,
    ) {
    }

    /**
     * @return array<string,mixed>
     */
    public function preview(?string $activeId = null): array
    {
        $shell = $this->shellChromeProvider->provide($activeId ?? 'shell.layout.preview');
        $topLinks = $shell['topLink'] ?? [];
        $primaryGroups = $shell['primaryGroup'] ?? [];
        $sectionGroups = $shell['sectionGroup'] ?? [];
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
                'primaryGroups' => count($primaryGroups),
                'sectionGroups' => count($sectionGroups),
                'rightGroups' => count($rightGroups),
                'footerGroups' => count($footerGroups),
                'knownCrudResources' => count($knownCrudResources),
            ],
            'modes' => [
                [
                    'id' => 'four-column',
                    'title' => 'Standard four-column shell',
                    'columns' => ['leftPrimary', 'leftSecondary', 'body', 'rightContext'],
                    'topPanelRequired' => true,
                    'footerRequired' => true,
                    'rightPanelEnabled' => true,
                    'cssGrid' => '260px 220px minmax(0, 1fr) 280px',
                    'useCase' => 'Default admin/workbench mode for CRUD, diagnostics, application dashboards and navigation maps.',
                ],
                [
                    'id' => 'three-column',
                    'title' => 'Compact three-column shell',
                    'columns' => ['leftPrimary', 'leftSecondary', 'body'],
                    'topPanelRequired' => true,
                    'footerRequired' => true,
                    'rightPanelEnabled' => false,
                    'cssGrid' => '260px 220px minmax(0, 1fr)',
                    'useCase' => 'Allowed only when a page explicitly disables the right context panel; Top and Footer remain mandatory.',
                ],
            ],
            'slots' => [
                ['id' => 'top', 'title' => 'Top panel', 'required' => true, 'source' => 'shell.topLink', 'count' => count($topLinks)],
                ['id' => 'leftPrimary', 'title' => 'Primary left panel', 'required' => true, 'source' => 'shell.primaryGroup', 'count' => count($primaryGroups)],
                ['id' => 'leftSecondary', 'title' => 'Secondary left panel', 'required' => true, 'source' => 'shell.sectionGroup', 'count' => count($sectionGroups)],
                ['id' => 'body', 'title' => 'Body', 'required' => true, 'source' => 'Twig body block', 'count' => 1],
                ['id' => 'rightContext', 'title' => 'Right context panel', 'required' => true, 'source' => 'shell.rightPanelGroup', 'count' => count($rightGroups)],
                ['id' => 'footer', 'title' => 'Footer', 'required' => true, 'source' => 'shell.footerGroup', 'count' => count($footerGroups)],
            ],
            'contract' => [
                'topAndFooterAlwaysRequired' => true,
                'defaultMode' => 'four-column',
                'compactMode' => 'three-column',
                'compactModeRule' => 'Only rightContext may be disabled; Top, both left panels, body and Footer must remain present.',
                'crudVisibilityRule' => 'Known connected, canonical and planned Smart Responsor resources must remain visible through shell navigation and application dashboards.',
            ],
        ];
    }
}
