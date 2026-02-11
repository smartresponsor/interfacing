<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Domain\Interfacing\Error;

/**
 *
 */

/**
 *
 */
final class UiMessage
{
    public const LEVEL_INFO = 'info';
    public const LEVEL_OK = 'ok';
    public const LEVEL_WARN = 'warn';
    public const LEVEL_ERROR = 'error';

    /**
     * @param string $level
     * @param string $text
     */
    public function __construct(
        private readonly string $level,
        private readonly string $text
    ) {
        $l = trim($this->level);
        $t = trim($this->text);
        if (!in_array($l, [self::LEVEL_INFO, self::LEVEL_OK, self::LEVEL_WARN, self::LEVEL_ERROR], true)) {
            throw new \InvalidArgumentException('Invalid message level.');
        }
        if ($t === '' || strlen($t) > 500) {
            throw new \InvalidArgumentException('Invalid message text.');
        }
        $this->level = $l;
        $this->text = $t;
    }

    /**
     * @return string
     */
    public function level(): string { return $this->level; }

    /**
     * @return string
     */
    public function text(): string { return $this->text; }
}
