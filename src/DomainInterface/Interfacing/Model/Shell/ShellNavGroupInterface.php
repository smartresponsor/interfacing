<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Shell;

interface ShellNavGroupInterface
{
    public function id(): string;

    public function title(): string;

    public function item(): array;
}
