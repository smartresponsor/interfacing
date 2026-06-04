<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Shell;

use App\Interfacing\Contract\View\InterfaceShellView;

interface InterfaceShellInterface
{
    public function view(): InterfaceShellView;
}
