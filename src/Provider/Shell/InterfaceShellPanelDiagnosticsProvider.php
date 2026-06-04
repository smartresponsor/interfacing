<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Shell;

use App\Interfacing\Contract\View\InterfaceShellFooterGroup;
use App\Interfacing\Contract\View\InterfaceShellNavGroup;
use App\Interfacing\ProviderInterface\Shell\InterfaceShellChromeProviderInterface;
use App\Interfacing\ProviderInterface\Shell\InterfaceShellPanelDiagnosticsProviderInterface;

final readonly class InterfaceShellPanelDiagnosticsProvider implements InterfaceShellPanelDiagnosticsProviderInterface
{
    /** @var list<array{id:string,label:string,key:string,type:string,required:bool}> */
    private const PANEL_CONTRACT = [
        ['id' => 'header', 'label' => 'Header panel', 'key' => 'topLink', 'type' => 'nav-list', 'required' => true],
        ['id' => 'left', 'label' => 'Left panel', 'key' => 'navigation.locations.shell.left.middle', 'type' => 'nav-list', 'required' => true],
        ['id' => 'context', 'label' => 'Context panel', 'key' => 'navigation.locations.shell.context.middle', 'type' => 'nav-list', 'required' => true],
        ['id' => 'main', 'label' => 'Main/content panel', 'key' => 'body', 'type' => 'twig-block', 'required' => true],
        ['id' => 'right', 'label' => 'Right panel', 'key' => 'rightPanelGroup', 'type' => 'nav-group-list', 'required' => true],
        ['id' => 'footer', 'label' => 'Footer panel', 'key' => 'footerGroup', 'type' => 'footer-group-list', 'required' => true],
    ];

    public function __construct(private InterfaceShellChromeProviderInterface $shellChromeProvider)
    {
    }

    public function report(?string $activeId = null): array
    {
        $shell = $this->shellChromeProvider->provide($activeId);
        $navigationLocations = is_array($shell['navigation']['locations'] ?? null) ? $shell['navigation']['locations'] : [];
        $panelStatus = [];
        foreach (self::PANEL_CONTRACT as $panel) {
            $panelStatus[] = $this->panelStatus($panel, $shell);
        }

        $missing = array_values(array_filter($panelStatus, static fn (array $status): bool => !$status['present']));
        $required = array_values(array_filter($panelStatus, static fn (array $status): bool => $status['required']));
        $presentRequired = array_values(array_filter($required, static fn (array $status): bool => $status['present']));

        return [
            'schema' => 'smart-responsor.interfacing.shell-panel-diagnostics.v1',
            'activeId' => $activeId,
            'mode' => ($shell['rightPanelEnabled'] ?? true) ? 'four-column' : 'three-column',
            'healthy' => [] === $missing,
            'summary' => [
                'requiredPanels' => count($required),
                'presentRequiredPanels' => count($presentRequired),
                'missingRequiredPanels' => count($missing),
                'topLinks' => $this->countItems($shell['topLink'] ?? []),
                'leftItems' => $this->countItems($navigationLocations['shell.left.middle'] ?? []),
                'contextItems' => $this->countItems($navigationLocations['shell.context.middle'] ?? []),
                'rightPanelItems' => $this->countGroupItems($shell['rightPanelGroup'] ?? []),
                'footerLinks' => $this->countFooterLinks($shell['footerGroup'] ?? []),
                'knownCrudResources' => is_countable($shell['knownCrudResources'] ?? null) ? count($shell['knownCrudResources']) : 0,
            ],
            'panels' => $panelStatus,
            'missingPanels' => $missing,
            'contract' => [
                'headerPanelRequired' => true,
                'leftPanelRequired' => true,
                'contextPanelRequired' => true,
                'mainPanelRequired' => true,
                'rightPanelRequiredInDefaultMode' => true,
                'footerPanelRequired' => true,
                'threeColumnModeAllowed' => true,
                'threeColumnModeRule' => 'Right panel may be disabled only when shell.rightPanelEnabled is false; header and footer remain mandatory.',
            ],
        ];
    }

    /**
     * @param array{id:string,label:string,key:string,type:string,required:bool} $panel
     * @param array<string,mixed>                                                $shell
     *
     * @return array{id:string,label:string,key:string,type:string,required:bool,present:bool,count:int,note:string}
     */
    private function panelStatus(array $panel, array $shell): array
    {
        if ('body' === $panel['key']) {
            return $panel + [
                'present' => true,
                'count' => 1,
                'note' => 'Provided by the required body block in templates/base.html.twig.',
            ];
        }

        if ('rightPanelGroup' === $panel['key'] && false === ($shell['rightPanelEnabled'] ?? true)) {
            return $panel + [
                'present' => true,
                'count' => 0,
                'note' => 'Right panel intentionally disabled for 3-column mode.',
            ];
        }

        $value = str_starts_with($panel['key'], 'navigation.locations.')
            ? ($shell['navigation']['locations'][str_replace('navigation.locations.', '', $panel['key'])] ?? null)
            : ($shell[$panel['key']] ?? null);
        $count = match ($panel['type']) {
            'nav-group-list' => $this->countGroupItems($value),
            'footer-group-list' => $this->countFooterLinks($value),
            default => $this->countItems($value),
        };

        return $panel + [
            'present' => $count > 0,
            'count' => $count,
            'note' => $count > 0 ? 'Panel source is populated by InterfaceShellChromeProvider.' : 'Panel source is empty or absent in InterfaceShellChromeProvider output.',
        ];
    }

    private function countItems(mixed $value): int
    {
        return is_countable($value) ? count($value) : 0;
    }

    private function countGroupItems(mixed $value): int
    {
        if (!is_iterable($value)) {
            return 0;
        }

        $count = 0;
        foreach ($value as $group) {
            if ($group instanceof InterfaceShellNavGroup) {
                $count += count($group->item());
                continue;
            }

            if (is_array($group) && isset($group['item']) && is_countable($group['item'])) {
                $count += count($group['item']);
            }
        }

        return $count;
    }

    private function countFooterLinks(mixed $value): int
    {
        if (!is_iterable($value)) {
            return 0;
        }

        $count = 0;
        foreach ($value as $group) {
            if ($group instanceof InterfaceShellFooterGroup) {
                $count += count($group->link());
                continue;
            }

            if (is_array($group) && isset($group['link']) && is_countable($group['link'])) {
                $count += count($group['link']);
            }
        }

        return $count;
    }
}
