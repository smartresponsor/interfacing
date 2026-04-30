<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

use App\Interfacing\Contract\ValueObject\ScreenIdInterface;

interface LayoutScreenSpecInterface
{
    /** @return array<int, LayoutBlockSpecInterface> */
    public function block(): array;

    public function id(): string;

    public function title(): string;

    public function description(): string;

    public function navGroup(): string;

    public function screenId(): ScreenIdInterface;

    public function guardKey(): ?string;

    public function routePath(): ?string;

    public function navOrder(): int;
}
