<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Shell;

use App\Interfacing\Contract\View\InterfaceShellFooterGroup;
use App\Interfacing\Contract\View\InterfaceShellFooterLink;
use App\Interfacing\Contract\View\InterfaceShellNavGroup;
use App\Interfacing\Contract\View\InterfaceShellNavItem;
use App\Interfacing\ProviderInterface\Shell\InterfaceShellChromeProviderInterface;
use App\Interfacing\ProviderInterface\Shell\InterfaceShellNavigationMapProviderInterface;

final readonly class InterfaceShellNavigationMapProvider implements InterfaceShellNavigationMapProviderInterface
{
    public function __construct(private InterfaceShellChromeProviderInterface $shellChromeProvider)
    {
    }

    public function map(?string $activeId = null): array
    {
        $shell = $this->shellChromeProvider->provide($activeId);
        $navigationLocations = is_array($shell['navigation']['locations'] ?? null) ? $shell['navigation']['locations'] : [];
        $panels = [
            'top' => [
                'label' => 'Top panel',
                'slot' => 'shell.header.right',
                'links' => $this->navItems($shell['topLink'] ?? []),
            ],
            'leftPrimary' => [
                'label' => 'Left primary panel',
                'slot' => 'shell.left.middle',
                'groups' => $this->navigationLocationGroups($navigationLocations, 'shell.left.middle', 'Primary navigation'),
            ],
            'leftSecondary' => [
                'label' => 'Left secondary panel',
                'slot' => 'shell.context.middle',
                'groups' => $this->navigationLocationGroups($navigationLocations, 'shell.context.middle', 'Context navigation'),
            ],
            'rightContext' => [
                'label' => 'Right context panel',
                'slot' => 'shell.right.middle',
                'enabled' => (bool) ($shell['rightPanelEnabled'] ?? true),
                'groups' => $this->navGroups($shell['rightPanelGroup'] ?? []),
            ],
            'footer' => [
                'label' => 'Footer panel',
                'slot' => 'shell.footer.left',
                'groups' => $this->footerGroups($shell['footerGroup'] ?? []),
            ],
        ];

        return [
            'schema' => 'smart-responsor.interfacing.shell-navigation-map.v1',
            'activeId' => $activeId,
            'mode' => ($shell['rightPanelEnabled'] ?? true) ? 'four-column' : 'three-column',
            'summary' => [
                'panelCount' => count($panels),
                'topLinks' => count($panels['top']['links']),
                'leftPrimaryLinks' => $this->countLinksInGroups($panels['leftPrimary']['groups']),
                'leftSecondaryLinks' => $this->countLinksInGroups($panels['leftSecondary']['groups']),
                'rightContextLinks' => $this->countLinksInGroups($panels['rightContext']['groups']),
                'footerLinks' => $this->countLinksInGroups($panels['footer']['groups']),
                'knownCrudResources' => is_countable($shell['knownCrudResources'] ?? null) ? count($shell['knownCrudResources']) : 0,
            ],
            'panels' => $panels,
            'knownCrudResources' => $shell['knownCrudResources'] ?? [],
            'contract' => [
                'topPanelRequired' => true,
                'leftPrimaryPanelRequired' => true,
                'leftSecondaryPanelRequired' => true,
                'bodyPanelRequired' => true,
                'rightContextPanelDefault' => true,
                'footerPanelRequired' => true,
                'linkPatternRule' => 'CRUD links must use the generic CRUD handoff URLs exposed by InterfaceCrudResourceExplorerProvider.',
            ],
        ];
    }

    /**
     * @param array<string, list<array<string, mixed>>> $locations
     *
     * @return list<array{id:string,title:string,links:list<array{id:string,title:string,url:string,group:string,icon:?string,order:int}>}>
     */
    private function navigationLocationGroups(array $locations, string $locationKey, string $title): array
    {
        $items = $locations[$locationKey] ?? [];

        if (!is_iterable($items) || [] === $items) {
            return [];
        }

        return [[
            'id' => $locationKey,
            'title' => $title,
            'links' => $this->navigationItems($items, $locationKey),
        ]];
    }

    /**
     * @return list<array{id:string,title:string,url:string,group:string,icon:?string,order:int}>
     */
    private function navigationItems(mixed $items, string $group): array
    {
        if (!is_iterable($items)) {
            return [];
        }

        $rows = [];
        foreach ($items as $item) {
            if (is_array($item)) {
                $rows[] = [
                    'id' => (string) ($item['key'] ?? $item['id'] ?? ''),
                    'title' => (string) ($item['label'] ?? $item['title'] ?? ''),
                    'url' => (string) ($item['url'] ?? $item['href'] ?? '#'),
                    'group' => $group,
                    'icon' => isset($item['metadata']['icon']) ? (string) $item['metadata']['icon'] : null,
                    'order' => (int) ($item['priority'] ?? $item['order'] ?? 100),
                ];
            }
        }

        usort($rows, static fn (array $a, array $b): int => [$a['order'], $a['title']] <=> [$b['order'], $b['title']]);

        return array_values($rows);
    }

    /**
     * @return list<array{id:string,title:string,url:string,group:string,icon:?string,order:int}>
     */
    private function navItems(mixed $items): array
    {
        if (!is_iterable($items)) {
            return [];
        }

        $rows = [];
        foreach ($items as $item) {
            if ($item instanceof InterfaceShellNavItem) {
                $rows[] = [
                    'id' => $item->id(),
                    'title' => $item->title(),
                    'url' => $item->url(),
                    'group' => $item->group(),
                    'icon' => $item->icon(),
                    'order' => $item->order(),
                ];
                continue;
            }

            if (is_array($item)) {
                $rows[] = [
                    'id' => (string) ($item['id'] ?? ''),
                    'title' => (string) ($item['title'] ?? ''),
                    'url' => (string) ($item['url'] ?? '#'),
                    'group' => (string) ($item['group'] ?? ''),
                    'icon' => isset($item['icon']) ? (string) $item['icon'] : null,
                    'order' => (int) ($item['order'] ?? 100),
                ];
            }
        }

        usort($rows, static fn (array $a, array $b): int => [$a['order'], $a['title']] <=> [$b['order'], $b['title']]);

        return array_values($rows);
    }

    /**
     * @return list<array{id:string,title:string,links:list<array{id:string,title:string,url:string,group:string,icon:?string,order:int}>}>
     */
    private function navGroups(mixed $groups): array
    {
        if (!is_iterable($groups)) {
            return [];
        }

        $rows = [];
        foreach ($groups as $group) {
            if ($group instanceof InterfaceShellNavGroup) {
                $rows[] = [
                    'id' => $group->id(),
                    'title' => $group->title(),
                    'links' => $this->navItems($group->item()),
                ];
                continue;
            }

            if (is_array($group)) {
                $rows[] = [
                    'id' => (string) ($group['id'] ?? ''),
                    'title' => (string) ($group['title'] ?? ''),
                    'links' => $this->navItems($group['item'] ?? []),
                ];
            }
        }

        return array_values($rows);
    }

    /**
     * @return list<array{id:string,title:string,links:list<array{id:string,title:string,url:string}>}>
     */
    private function footerGroups(mixed $groups): array
    {
        if (!is_iterable($groups)) {
            return [];
        }

        $rows = [];
        foreach ($groups as $group) {
            if ($group instanceof InterfaceShellFooterGroup) {
                $rows[] = [
                    'id' => $group->id(),
                    'title' => $group->title(),
                    'links' => $this->footerLinks($group->link()),
                ];
                continue;
            }

            if (is_array($group)) {
                $rows[] = [
                    'id' => (string) ($group['id'] ?? ''),
                    'title' => (string) ($group['title'] ?? ''),
                    'links' => $this->footerLinks($group['link'] ?? []),
                ];
            }
        }

        return array_values($rows);
    }

    /**
     * @return list<array{id:string,title:string,url:string}>
     */
    private function footerLinks(mixed $links): array
    {
        if (!is_iterable($links)) {
            return [];
        }

        $rows = [];
        foreach ($links as $index => $link) {
            if ($link instanceof InterfaceShellFooterLink) {
                $rows[] = [
                    'id' => 'footer.'.((int) $index),
                    'title' => $link->title(),
                    'url' => $link->url(),
                ];
                continue;
            }

            if (is_array($link)) {
                $rows[] = [
                    'id' => (string) ($link['id'] ?? 'footer.'.((int) $index)),
                    'title' => (string) ($link['title'] ?? ''),
                    'url' => (string) ($link['url'] ?? '#'),
                ];
            }
        }

        return array_values($rows);
    }

    /**
     * @param list<array{id:string,title:string,links:list<array<string,mixed>>}> $groups
     */
    private function countLinksInGroups(array $groups): int
    {
        $count = 0;
        foreach ($groups as $group) {
            $count += count($group['links']);
        }

        return $count;
    }
}
