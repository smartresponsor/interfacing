<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Dto;

interface InterfaceUiStateInterface
{
    public function with(string $key, mixed $value): self;

    public function get(string $key, mixed $default = null): mixed;

    /** @return array<string, mixed> */
    public function toArray(): array;
}
