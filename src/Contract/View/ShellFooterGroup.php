<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final class ShellFooterGroup implements ShellFooterGroupInterface
{
    /** @param list<ShellFooterLinkInterface> $link */
    public function __construct(
        private readonly string $id,
        private readonly string $title,
        private readonly array $link,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function link(): array
    {
        return $this->link;
    }
}
