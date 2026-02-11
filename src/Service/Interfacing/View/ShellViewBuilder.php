<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Service\Interfacing\View;

    use App\ServiceInterface\Interfacing\Action\ActionRegistryInterface;
use App\ServiceInterface\Interfacing\Registry\ScreenRegistryInterface;
use App\ServiceInterface\Interfacing\View\ShellViewBuilderInterface;

final class ShellViewBuilder implements ShellViewBuilderInterface
{
    public function __construct(
        private readonly ScreenRegistryInterface $screenRegistry,
        private readonly ActionRegistryInterface $actionRegistry,
    ) {}

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

