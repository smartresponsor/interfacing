<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing\View;

use App\Contract\Error\ScreenForbidden;
use App\Contract\Error\ScreenNotFound;
use App\Contract\ValueObject\LayoutSlot;
use App\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use App\ServiceInterface\Interfacing\Shell\AccessResolverInterface;
use App\ServiceInterface\Interfacing\View\ScreenViewBuilderInterface;

final readonly class ScreenViewBuilder implements ScreenViewBuilderInterface
{
    public function __construct(
        private LayoutCatalogInterface $layout,
        private ScreenRegistryInterface $screen,
        private ScreenContextAssemblerInterface $context,
        private AccessResolverInterface $access,
    ) {
    }

    public function build(string $layoutId): array
    {
        $spec = $this->layout->find($layoutId);
        if (null === $spec) {
            throw ScreenNotFound::forLayoutId($layoutId);
        }

        $cap = $spec->capability();
        if (null !== $cap && !$this->access->allow($cap, [
            'layoutId' => $spec->id(),
            'screenId' => $spec->screenId()->toString(),
        ])) {
            throw ScreenForbidden::forLayoutId($layoutId);
        }

        $component = $this->screen->componentName($spec->screenId());
        $context = $this->context->contextFor($spec);

        return [
            'spec' => $spec,
            'component' => $component,
            'context' => $context,
            'title' => $spec->title(),
            'layoutContract' => [
                'version' => 1,
                'slot' => LayoutSlot::all(),
            ],
        ];
    }
}
