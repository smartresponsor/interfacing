<?php

declare(strict_types=1);

namespace App\Contract\View;

final readonly class LayoutBlockSpec implements LayoutBlockSpecInterface
{
    /** @param array<string, mixed> $props */
    public function __construct(
        private string $type,
        private string $key,
        private array $props = [],
    ) {
    }

    public function type(): string
    {
        return $this->type;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function props(): array
    {
        return $this->props;
    }
}
