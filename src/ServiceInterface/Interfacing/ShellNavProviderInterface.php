<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\ShellNavGroup;

interface ShellNavProviderInterface
{
    /** @return list<ShellNavGroup> */
    public function provide(): array;
}
