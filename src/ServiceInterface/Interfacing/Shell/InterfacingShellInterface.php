<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Shell;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Shell\ShellView;

interface InterfacingShellInterface
{
    public function view(): ShellView;
}
