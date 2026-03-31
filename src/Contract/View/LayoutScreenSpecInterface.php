<?php

declare(strict_types=1);

namespace App\Contract\View;

use App\Contract\ValueObject\ScreenIdInterface;

interface LayoutScreenSpecInterface
{
    /** @return array<int, LayoutBlockSpecInterface> */
    public function block(): array;

    public function id(): string;

    public function title(): string;

    public function navGroup(): string;

    public function screenId(): ScreenIdInterface;

    public function guardKey(): ?string;

    public function routePath(): ?string;

    public function navOrder(): int;
}
