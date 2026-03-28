<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\ServiceInterface\Interfacing\Shell;

use App\Contract\View\ShellView;

interface InterfacingShellInterface
{
    public function view(): ShellView;
}
