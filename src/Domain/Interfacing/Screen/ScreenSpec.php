<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Domain\Interfacing\Screen;

use SmartResponsor\Interfacing\Domain\Interfacing\Access\AccessRule;

final class ScreenSpec
{
    /**
     * @param AccessRule[] $accessRule
     */
    public function __construct(
        private readonly ScreenId $screenId,
        private readonly string $title,
        private readonly string $layoutKey,
        private readonly array $accessRule = []
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

    public function screenId(): ScreenId
    {
        return $this->screenId;
    }

    public function title(): string
    {
        return $this->title;
    }

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
