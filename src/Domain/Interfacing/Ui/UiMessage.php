<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Domain\Interfacing\Ui;

use App\DomainInterface\Interfacing\Ui\UiMessageInterface;

/**
 *
 */

/**
 *
 */
final readonly class UiMessage implements UiMessageInterface
{
    /**
     * @param string $type
     * @param string $text
     * @param string|null $code
     */
    public function __construct(
        private string  $type,
        private string  $text,
        private ?string $code = null,
    ) {
        if ($type === '') {
            throw new \InvalidArgumentException('UiMessage type must not be empty.');
        }
        if ($text === '') {
            throw new \InvalidArgumentException('UiMessage text must not be empty.');
        }
    }

    /**
     * @return string
     */
    public function type(): string { return $this->type; }

    /**
     * @return string
     */
    public function text(): string { return $this->text; }

    /**
     * @return string|null
     */
    public function code(): ?string { return $this->code; }
}

