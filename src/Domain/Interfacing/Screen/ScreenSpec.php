<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Domain\Interfacing\Screen;

use App\Domain\Interfacing\Access\AccessRule;

/**
 *
 */

/**
 *
 */
final readonly class ScreenSpec
{
    /**
     * @param AccessRule[] $accessRule
     */
    public function __construct(
        private ScreenId $screenId,
        private string   $title,
        private string   $layoutKey,
        private array    $accessRule = []
    ) {
        $t = trim($this->title);
        if ($t === '' || strlen($t) > 190) {
            throw new \InvalidArgumentException('Invalid screen title.');
        }
        $k = trim($this->layoutKey);
        if ($k === '' || strlen($k) > 190) {
            throw new \InvalidArgumentException('Invalid layout key.');
        }
        $this->title = $t;
        $this->layoutKey = $k;
    }

    /**
     * @return \App\Domain\Interfacing\Screen\ScreenId
     */
    public function screenId(): ScreenId
    {
        return $this->screenId;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function layoutKey(): string
    {
        return $this->layoutKey;
    }

    /** @return AccessRule[] */
    public function accessRule(): array
    {
        return $this->accessRule;
    }
}
