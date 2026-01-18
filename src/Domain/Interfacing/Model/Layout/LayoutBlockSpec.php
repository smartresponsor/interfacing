<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Domain\Interfacing\Model\Layout;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutBlockSpecInterface;

final class LayoutBlockSpec implements LayoutBlockSpecInterface
{
    /** @param array<string, mixed> $props */
    public function __construct(
        private readonly string $type,
        private readonly string $key,
        private readonly array $props = [],
    ) {}

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

