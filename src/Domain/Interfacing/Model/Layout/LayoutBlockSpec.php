<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Domain\Interfacing\Model\Layout;

    use App\DomainInterface\Interfacing\Model\Layout\LayoutBlockSpecInterface;

    /**
     *
     */

    /**
     *
     */
    final readonly class LayoutBlockSpec implements LayoutBlockSpecInterface
{
    /** @param array<string, mixed> $props */
    public function __construct(
        private string $type,
        private string $key,
        private array  $props = [],
    ) {}

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * @return mixed[]
     */
    public function props(): array
    {
        return $this->props;
    }
}

