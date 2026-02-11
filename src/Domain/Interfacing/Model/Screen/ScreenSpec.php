<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Domain\Interfacing\Model\Screen;

    use App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;
use App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

    /**
     *
     */

    /**
     *
     */
    final readonly class ScreenSpec implements ScreenSpecInterface
{
    /** @param array<int, string> $requireRole
     *  @param array<string, mixed> $defaultState
     */
    public function __construct(
        private string                    $id,
        private string                    $title,
        private LayoutScreenSpecInterface $layout,
        private array                     $defaultState = [],
        private array                     $requireRole = [],
    ) {}

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string[]
     */
    public function requireRole(): array
    {
        return $this->requireRole;
    }

    /**
     * @return \App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface
     */
    public function layout(): LayoutScreenSpecInterface
    {
        return $this->layout;
    }

    /**
     * @return mixed[]
     */
    public function defaultState(): array
    {
        return $this->defaultState;
    }
}

