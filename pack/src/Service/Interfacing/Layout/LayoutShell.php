<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Service\Interfacing\Layout;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Layout\LayoutNavSpec;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutNavSpecInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutShellInterface;

/**
 *
 */

/**
 *
 */
final readonly class LayoutShell implements LayoutShellInterface
{
    /**
     * @param \SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface $catalog
     */
    public function __construct(
        private LayoutCatalogInterface $catalog,
    ) {
    }

    /**
     * @param string $activeSlug
     * @return \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutNavSpecInterface
     */
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

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface $active
     * @return array
     */
    public function build(LayoutScreenSpecInterface $active): array
    {
        return [
            'title' => $active->getTitle(),
            'nav' => $this->buildNav($active->getSlug()),
            'active' => $active,
        ];
    }
}
