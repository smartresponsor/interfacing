<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

interface InterfaceShellFooterGroupInterface
{
    public function id(): string;

    public function title(): string;

    /** @return list<InterfaceShellFooterLinkInterface> */
    public function link(): array;
}
