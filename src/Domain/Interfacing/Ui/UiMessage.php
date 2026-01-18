<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\Domain\Interfacing\Ui;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Ui\UiMessageInterface;

final class UiMessage implements UiMessageInterface
{
    public function __construct(
        private readonly string $type,
        private readonly string $text,
        private readonly ?string $code = null,
    ) {
        if ($type === '') {
            throw new \InvalidArgumentException('UiMessage type must not be empty.');
        }
        if ($text === '') {
            throw new \InvalidArgumentException('UiMessage text must not be empty.');
        }
    }

    public function type(): string { return $this->type; }
    public function text(): string { return $this->text; }
    public function code(): ?string { return $this->code; }
}

