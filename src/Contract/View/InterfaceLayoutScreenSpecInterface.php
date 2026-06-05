<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

use App\Interfacing\Contract\ValueObject\InterfaceScreenIdInterface;

interface InterfaceLayoutScreenSpecInterface
{
    /** @return array<int, InterfaceLayoutBlockSpecInterface> */
    public function block(): array;

    public function id(): string;

    /**
     * BC alias used by older shell templates.
     */
    public function slug(): string;

    public function title(): string;

    public function description(): string;

    public function navGroup(): string;

    public function icon(): ?string;

    public function screenId(): InterfaceScreenIdInterface;

    public function guardKey(): ?string;

    public function routePath(): ?string;

    public function navOrder(): int;

    /** @return array<string, mixed> */
    public function context(): array;
}
