<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Builder\View;

use App\Interfacing\BuilderInterface\View\InterfaceShellViewBuilderInterface;
use App\Interfacing\RegistryInterface\Action\InterfaceActionRegistryInterface;
use App\Interfacing\RegistryInterface\AttributeRegistry\InterfaceScreenRegistryInterface;

final readonly class InterfaceShellViewBuilder implements InterfaceShellViewBuilderInterface
{
    public function __construct(
        private InterfaceScreenRegistryInterface $screenRegistry,
        private InterfaceActionRegistryInterface $actionRegistry,
    ) {
    }

    /**
     * @return array|mixed[]
     */
    public function build(string $activeScreenId): array
    {
        $screenList = [];
        foreach ($this->screenRegistry->all() as $screen) {
            $screenList[] = [
                'id' => $screen->id(),
                'title' => $screen->title(),
                'active' => $screen->id() === $activeScreenId,
            ];
        }

        $actionList = $this->screenRegistry->has($activeScreenId)
            ? $this->actionRegistry->listForScreen($activeScreenId)
            : [];

        return [
            'screenList' => $screenList,
            'actionList' => $actionList,
        ];
    }
}
