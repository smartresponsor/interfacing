<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Domain\Interfacing\Layout;

/**
 *
 */

/**
 *
 */
final readonly class LayoutSpec
{
    /**
     * @param array<int, array<string, mixed>> $block
     */
    public function __construct(
        private string $layoutKey,
        private string $shellTitle,
        private array  $block
    ) {
        $k = trim($this->layoutKey);
        if ($k === '' || strlen($k) > 190) {
            throw new \InvalidArgumentException('Invalid layout key.');
        }
        $t = trim($this->shellTitle);
        if ($t === '' || strlen($t) > 190) {
            throw new \InvalidArgumentException('Invalid shell title.');
        }
        $this->layoutKey = $k;
        $this->shellTitle = $t;
    }

    /**
     * @return string
     */
    public function layoutKey(): string
    {
        return $this->layoutKey;
    }

    /**
     * @return string
     */
    public function shellTitle(): string
    {
        return $this->shellTitle;
    }

    /** @return array<int, array<string, mixed>> */
    public function block(): array
    {
        return $this->block;
    }
}
