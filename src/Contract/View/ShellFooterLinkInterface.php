<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

interface ShellFooterLinkInterface
{
    public function title(): string;

    public function url(): string;
}
