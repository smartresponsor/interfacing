<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model;

interface UiStateInterface
{
    public function with(string $key, mixed $value): self;

    public function get(string $key, mixed $default = null): mixed;

    public function toArray(): array;
}
