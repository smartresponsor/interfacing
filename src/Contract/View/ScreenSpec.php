<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class ScreenSpec implements ScreenSpecInterface
{
    /**
     * @param array<int, string>   $requireRole
     * @param array<string, mixed> $defaultState
     */
    public function __construct(
        private string $id,
        private string $title,
        private LayoutScreenSpecInterface $layout,
        private array $defaultState = [],
        private array $requireRole = [],
        private string $description = '',
        private string $viewId = '',
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function viewId(): string
    {
        return '' !== $this->viewId ? $this->viewId : ($this->layout->routePath() ?? $this->layout->id());
    }

    public function requireRole(): array
    {
        return $this->requireRole;
    }

    public function layout(): LayoutScreenSpecInterface
    {
        return $this->layout;
    }

    public function defaultState(): array
    {
        return $this->defaultState;
    }
}
