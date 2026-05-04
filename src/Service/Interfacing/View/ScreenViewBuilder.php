<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Service\Interfacing\View;

use App\Interfacing\Contract\Error\ScreenForbidden;
use App\Interfacing\Contract\Error\ScreenNotFound;
use App\Interfacing\Contract\ValueObject\LayoutSlot;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\CapabilityAccessResolverInterface;
use App\Interfacing\ServiceInterface\Interfacing\View\ScreenViewBuilderInterface;

final readonly class ScreenViewBuilder implements ScreenViewBuilderInterface
{
    public function __construct(
        private LayoutCatalogInterface $layout,
        private ScreenRegistryInterface $screen,
        private ScreenContextAssemblerInterface $context,
        private CapabilityAccessResolverInterface $access,
    ) {
    }

    public function build(string $layoutId): array
    {
        $spec = $this->layout->find($layoutId);
        if (null === $spec) {
            throw ScreenNotFound::forLayoutId($layoutId);
        }

        $cap = $spec->guardKey();
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
