<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Service\Interfacing\Shell;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Shell\ShellNavGroup;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\Shell\ShellNavItem;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\Shell\ShellView;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Shell\AccessResolverInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Shell\InterfacingShellInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class InterfacingShell implements InterfacingShellInterface
{
    public function __construct(
        private LayoutCatalogInterface $layout,
        private RequestStack $requestStack,
        private UrlGeneratorInterface $url,
        private AccessResolverInterface $access,
    ) {
    }

    public function view(): ShellView
    {
        $req = $this->requestStack->getCurrentRequest();
        $activeId = null;
        $query = '';

        if ($req !== null) {
            $query = (string)$req->query->get('q', '');
            $rid = $req->attributes->get('_route', null);
            if ($rid === 'interfacing_screen') {
                $activeId = (string)$req->attributes->get('id', '');
                $activeId = trim($activeId) !== '' ? trim($activeId) : null;
            }
        }

        $queryNorm = trim($query);

        $specList = $this->layout->list();
        $itemList = [];
        foreach ($specList as $spec) {
            $cap = $spec->capability();
            if ($cap !== null && !$this->access->allow($cap, ['layoutId' => $spec->id(), 'screenId' => $spec->screenId()->toString()])) {
                continue;
            }

            $url = $this->url->generate('interfacing_screen', ['id' => $spec->id()]);
            if ($queryNorm !== '') {
                $url .= '?q='.rawurlencode($queryNorm);
            }

            $itemList[] = new ShellNavItem(
                id: $spec->id(),
                title: $spec->title(),
                url: $url,
                group: $spec->group(),
                icon: $spec->icon(),
                order: $spec->order(),
            );
        }

        if ($queryNorm !== '') {
            $q = mb_strtolower($queryNorm);
            $itemList = array_values(array_filter($itemList, static function (ShellNavItem $it) use ($q): bool {
                return str_contains(mb_strtolower($it->title()), $q) || str_contains(mb_strtolower($it->id()), $q);
            }));
        }

        $groupMap = [];
        foreach ($itemList as $it) {
            $gid = $it->group();
            $groupMap[$gid] ??= [];
            $groupMap[$gid][] = $it;
        }

        ksort($groupMap);

        $group = [];
        $total = 0;
        foreach ($groupMap as $gid => $list) {
            usort($list, static function (ShellNavItem $a, ShellNavItem $b): int {
                $o = $a->order() <=> $b->order();
                if ($o !== 0) { return $o; }
                return $a->title() <=> $b->title();
            });
            $total += count($list);
            $group[] = new ShellNavGroup($gid, $this->titleize($gid), $list);
        }

        return new ShellView($activeId, $queryNorm, $group, $total);
    }

    private function titleize(string $id): string
    {
        $id = str_replace(['_', '-'], ' ', $id);
        $id = trim($id);
        if ($id === '') {
            return 'Tool';
        }

        return mb_convert_case($id, MB_CASE_TITLE, 'UTF-8');
    }
}
