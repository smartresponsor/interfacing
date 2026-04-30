<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final class ShellFooterLink implements ShellFooterLinkInterface
{
    public function __construct(
        private readonly string $title,
        private readonly string $url,
    ) {
    }

    public function title(): string
    {
        return $this->title;
    }

    public function url(): string
    {
        return $this->url;
    }
}
