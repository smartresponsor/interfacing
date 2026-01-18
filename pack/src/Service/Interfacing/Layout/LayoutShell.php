<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\Service\Interfacing\Layout;

use App\Domain\Interfacing\Model\Layout\LayoutNavSpec;
use App\DomainInterface\Interfacing\Model\Layout\LayoutNavSpecInterface;
use App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;
use App\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\ServiceInterface\Interfacing\Layout\LayoutShellInterface;

final class LayoutShell implements LayoutShellInterface
{
    public function __construct(
        private readonly LayoutCatalogInterface $catalog,
    ) {
    }

    public function buildNav(string $activeSlug): LayoutNavSpecInterface
    {
        $groupItem = [];
        foreach ($this->catalog->all() as $spec) {
            $group = $spec->getNavGroup();
            $groupItem[$group] ??= [];
            $groupItem[$group][] = [
                'slug' => $spec->getSlug(),
                'title' => $spec->getTitle(),
                'active' => $spec->getSlug() === $activeSlug,
            ];
        }

        ksort($groupItem);
        foreach ($groupItem as $group => $items) {
            usort($items, static fn($a, $b) => strcmp($a['slug'], $b['slug']));
            $groupItem[$group] = $items;
        }

        return LayoutNavSpec::create($groupItem, $activeSlug);
    }

    public function build(LayoutScreenSpecInterface $active): array
    {
        return [
            'title' => $active->getTitle(),
            'nav' => $this->buildNav($active->getSlug()),
            'active' => $active,
        ];
    }
}
