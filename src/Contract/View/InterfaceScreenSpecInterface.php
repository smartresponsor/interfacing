<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

interface InterfaceScreenSpecInterface
{
    public function id(): string;

    public function title(): string;

    public function description(): string;

    public function viewId(): string;

    /** @return array<int, string> */
    public function requireRole(): array;

    public function layout(): InterfaceLayoutScreenSpecInterface;

    /** @return array<string, mixed> */
    public function defaultState(): array;
}
