<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

interface ShellFooterGroupInterface
{
    public function id(): string;

    public function title(): string;

    /** @return list<ShellFooterLinkInterface> */
    public function link(): array;
}
