<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Domain\Interfacing\Model\Layout;

    use App\DomainInterface\Interfacing\Model\Layout\LayoutBlockSpecInterface;
use App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;

    /**
     *
     */

    /**
     *
     */
    final readonly class LayoutScreenSpec implements LayoutScreenSpecInterface
{
    /** @param array<int, LayoutBlockSpecInterface> $block */
    public function __construct(
        private array $block,
    ) {}

    /**
     * @return \App\DomainInterface\Interfacing\Model\Layout\LayoutBlockSpecInterface[]
     */
    public function block(): array
    {
        return $this->block;
    }
}

