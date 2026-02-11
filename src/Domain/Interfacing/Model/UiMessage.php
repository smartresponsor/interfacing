<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Model;

final class UiMessage
{
    public const LEVEL_INFO = 'info';
    public const LEVEL_SUCCESS = 'success';
    public const LEVEL_WARNING = 'warning';
    public const LEVEL_ERROR = 'error';

    private string $level;
    private string $text;

    private function __construct(string $level, string $text)
    {
        if ($text === '') {
            throw new \InvalidArgumentException('UiMessage text must not be empty.');
        }
        $this->level = $level;
        $this->text = $text;
    }

    public static function info(string $text): self { return new self(self::LEVEL_INFO, $text); }
    public static function success(string $text): self { return new self(self::LEVEL_SUCCESS, $text); }
    public static function warning(string $text): self { return new self(self::LEVEL_WARNING, $text); }
    public static function error(string $text): self { return new self(self::LEVEL_ERROR, $text); }

    public function level(): string { return $this->level; }
    public function text(): string { return $this->text; }
}
