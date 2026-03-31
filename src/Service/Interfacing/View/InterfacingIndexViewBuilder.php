<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Service\Interfacing\View;

use App\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\ServiceInterface\Interfacing\Shell\AccessResolverInterface;
use App\ServiceInterface\Interfacing\View\InterfacingIndexViewBuilderInterface;

final readonly class InterfacingIndexViewBuilder implements InterfacingIndexViewBuilderInterface
{
    public function __construct(
        private LayoutCatalogInterface $layout,
        private AccessResolverInterface $access,
    ) {
    }

    public function build(): array
    {
        $screenList = [];

        foreach ($this->layout->list() as $spec) {
            $cap = $spec->capability();
            if (null !== $cap && !$this->access->allow($cap, [
                'layoutId' => $spec->id(),
                'screenId' => $spec->screenId()->toString(),
            ])) {
                continue;
            }

            $screenList[] = [
                'id' => $spec->id(),
                'title' => $spec->title(),
            ];
        }

        usort($screenList, static fn (array $a, array $b): int => $a['title'] <=> $b['title']);

        return [
            'screenList' => $screenList,
        ];
    }
}
