<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

interface ScreenSpecInterface
{
    public function id(): string;

    public function title(): string;

    public function description(): string;

    public function viewId(): string;

    /** @return array<int, string> */
    public function requireRole(): array;

    public function layout(): LayoutScreenSpecInterface;

    /** @return array<string, mixed> */
    public function defaultState(): array;
}
