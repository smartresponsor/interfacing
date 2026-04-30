<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\View;

use App\Interfacing\ServiceInterface\Interfacing\Action\ActionRegistryInterface;
use App\Interfacing\ServiceInterface\Interfacing\Registry\ScreenRegistryInterface;
use App\Interfacing\ServiceInterface\Interfacing\View\ShellViewBuilderInterface;

/**
 *
 */

/**
 *
 */
final readonly class ShellViewBuilder implements ShellViewBuilderInterface
{
    /**
     * @param \App\Interfacing\ServiceInterface\Interfacing\Registry\ScreenRegistryInterface $screenRegistry
     * @param \App\Interfacing\ServiceInterface\Interfacing\Action\ActionRegistryInterface $actionRegistry
     */
    public function __construct(
        private ScreenRegistryInterface $screenRegistry,
        private ActionRegistryInterface $actionRegistry,
    ) {
    }

    /**
     * @param string $activeScreenId
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
