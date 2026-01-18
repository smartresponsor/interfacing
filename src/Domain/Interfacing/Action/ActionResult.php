<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Domain\Interfacing\Action;

use SmartResponsor\Interfacing\Domain\Interfacing\Error\UiError;
use SmartResponsor\Interfacing\Domain\Interfacing\Error\UiMessage;

final class ActionResult
{
    /** @var UiError[] */
    private array $error = [];

    /** @var UiMessage[] */
    private array $message = [];

    /**
     * @param array<string, mixed> $data
     */
    private function __construct(
        private readonly string $type,
        private readonly array $data = []
    ) {}

    public static function ok(array $data = []): self
    {
        return new self('ok', $data);
    }

    /**
     * @param UiError[] $error
     * @param UiMessage[] $message
     */
    public static function fail(array $error, array $message = []): self
    {
        $r = new self('fail');
        $r->error = array_values($error);
        $r->message = array_values($message);
        return $r;
    }

    public static function redirect(string $url): self
    {
        $u = trim($url);
        if ($u === '' || strlen($u) > 2000) {
            throw new \InvalidArgumentException('Invalid redirect url.');
        }
        return new self('redirect', ['url' => $u]);
    }

    public function type(): string
    {
        return $this->type;
    }

    /** @return array<string, mixed> */
    public function data(): array
    {
        return $this->data;
    }

    /** @return UiError[] */
    public function error(): array
    {
        return $this->error;
    }

    /** @return UiMessage[] */
    public function message(): array
    {
        return $this->message;
    }
}
