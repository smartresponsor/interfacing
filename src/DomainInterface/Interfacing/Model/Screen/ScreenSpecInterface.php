<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\DomainInterface\Interfacing\Model\Screen;

    use App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;

    /**
     *
     */

    /**
     *
     */
    interface ScreenSpecInterface
{
    /**
     * @return string
     */
    public function id(): string;

    /**
     * @return string
     */
    public function title(): string;

    /** @return array<int, string> */
    public function requireRole(): array;

    /**
     * @return \App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface
     */
    public function layout(): LayoutScreenSpecInterface;

    /** @return array<string, mixed> */
    public function defaultState(): array;
}

