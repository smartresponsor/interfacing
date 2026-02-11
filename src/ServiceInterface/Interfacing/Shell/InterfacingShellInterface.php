<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Shell;

use App\Domain\Interfacing\Model\Shell\ShellView;

/**
 *
 */

/**
 *
 */
interface InterfacingShellInterface
{
    /**
     * @return \App\Domain\Interfacing\Model\Shell\ShellView
     */
    public function view(): ShellView;
}
