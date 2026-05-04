<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Interfacing\View;

interface InterfacingWorkspaceViewBuilderInterface
{
    /** @return array<string, mixed> */
    public function build(string $page): array;
}
