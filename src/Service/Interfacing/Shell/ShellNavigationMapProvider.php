<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Shell;

use App\Interfacing\Contract\View\ShellFooterGroup;
use App\Interfacing\Contract\View\ShellFooterLink;
use App\Interfacing\Contract\View\ShellNavGroup;
use App\Interfacing\Contract\View\ShellNavItem;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellChromeProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellNavigationMapProviderInterface;

final readonly class ShellNavigationMapProvider implements ShellNavigationMapProviderInterface
{
    public function __construct(private ShellChromeProviderInterface $shellChromeProvider)
    {
    }

    public function map(?string $activeId = null): array
    {
        $shell = $this->shellChromeProvider->provide($activeId);
        $panels = [
            'top' => [
                'label' => 'Top panel',
                'slot' => 'shell.topbar.right',
                'links' => $this->navItems($shell['topLink'] ?? []),
            ],
            'leftPrimary' => [
                'label' => 'Left primary panel',
                'slot' => 'shell.nav.primary',
                'groups' => $this->navGroups($shell['primaryGroup'] ?? []),
            ],
            'leftSecondary' => [
                'label' => 'Left secondary panel',
                'slot' => 'shell.nav.section',
                'groups' => $this->navGroups($shell['sectionGroup'] ?? []),
            ],
            'rightContext' => [
                'label' => 'Right context panel',
                'slot' => 'shell.context.right',
                'enabled' => (bool) ($shell['rightPanelEnabled'] ?? true),
                'groups' => $this->navGroups($shell['rightPanelGroup'] ?? []),
            ],
            'footer' => [
                'label' => 'Footer panel',
                'slot' => 'shell.footer.primary',
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
                'linkPatternRule' => 'CRUD links must use the generic CRUD bridge URLs exposed by CrudResourceExplorerProvider.',
            ],
        ];
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
            if ($item instanceof ShellNavItem) {
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
            if ($group instanceof ShellNavGroup) {
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
            if ($group instanceof ShellFooterGroup) {
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
            if ($link instanceof ShellFooterLink) {
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
