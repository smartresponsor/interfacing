<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Style;

interface InterfaceStyleProviderInterface
{
    public function key(): string;

    public function label(): string;

    public function bodyClass(): string;

    public function locationClass(): string;

    public function stylesheet(): string;

    /**
     * @return array<string, mixed>
     */
    public function manifest(): array;
}
