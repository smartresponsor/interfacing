<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Service\Interfacing\View;

use SmartResponsor\Interfacing\Domain\Interfacing\Layout\LayoutSlot;
use SmartResponsor\Interfacing\Domain\Interfacing\Error\ScreenForbidden;
use SmartResponsor\Interfacing\Domain\Interfacing\Error\ScreenNotFound;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Shell\AccessResolverInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\View\ScreenViewBuilderInterface;

/**
 *
 */

/**
 *
 */
final readonly class ScreenViewBuilder implements ScreenViewBuilderInterface
{
    /**
     * @param \SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface $layout
     * @param \SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface $screen
     * @param \SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface $context
     * @param \SmartResponsor\Interfacing\ServiceInterface\Interfacing\Shell\AccessResolverInterface $access
     */
    public function __construct(
        private LayoutCatalogInterface          $layout,
        private ScreenRegistryInterface         $screen,
        private ScreenContextAssemblerInterface $context,
        private AccessResolverInterface         $access,
    ) {}

    /**
     * @param string $layoutId
     * @return array
     */
    public function build(string $layoutId): array
    {
        $spec = $this->layout->find($layoutId);
        if ($spec === null) {
            throw ScreenNotFound::forLayoutId($layoutId);
        }

        $cap = $spec->capability();
        if ($cap !== null && !$this->access->allow($cap, [
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
