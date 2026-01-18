<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Domain\Interfacing\Model\Screen;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

final class ScreenSpec implements ScreenSpecInterface
{
    /** @param array<int, string> $requireRole
     *  @param array<string, mixed> $defaultState
     */
    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly LayoutScreenSpecInterface $layout,
        private readonly array $defaultState = [],
        private readonly array $requireRole = [],
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
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

