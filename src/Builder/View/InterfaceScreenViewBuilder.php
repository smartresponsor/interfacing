<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Builder\View;

use App\Interfacing\AssemblerInterface\Runtime\InterfaceScreenContextAssemblerInterface;
use App\Interfacing\BuilderInterface\View\InterfaceScreenViewBuilderInterface;
use App\Interfacing\CatalogInterface\Layout\InterfaceLayoutCatalogInterface;
use App\Interfacing\Contract\Error\InterfaceScreenForbidden;
use App\Interfacing\Contract\Error\InterfaceScreenNotFound;
use App\Interfacing\Contract\ValueObject\InterfaceLayoutSlot;
use App\Interfacing\RegistryInterface\Runtime\InterfaceScreenRegistryInterface;
use App\Interfacing\ResolverInterface\Shell\InterfaceCapabilityAccessResolverInterface;

final readonly class InterfaceScreenViewBuilder implements InterfaceScreenViewBuilderInterface
{
    public function __construct(
        private InterfaceLayoutCatalogInterface $layout,
        private InterfaceScreenRegistryInterface $screen,
        private InterfaceScreenContextAssemblerInterface $context,
        private InterfaceCapabilityAccessResolverInterface $access,
    ) {
    }

    public function build(string $layoutId): array
    {
        $spec = $this->layout->find($layoutId);
        if (null === $spec) {
            throw InterfaceScreenNotFound::forLayoutId($layoutId);
        }

        $cap = $spec->guardKey();
        if (null !== $cap && !$this->access->allow($cap, [
            'layoutId' => $spec->id(),
            'screenId' => $spec->screenId()->toString(),
        ])) {
            throw InterfaceScreenForbidden::forLayoutId($layoutId);
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
                'slot' => InterfaceLayoutSlot::all(),
            ],
        ];
    }
}
