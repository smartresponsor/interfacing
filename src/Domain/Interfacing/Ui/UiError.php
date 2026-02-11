<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Domain\Interfacing\Ui;

use App\DomainInterface\Interfacing\Ui\UiErrorInterface;

/**
 *
 */

/**
 *
 */
final readonly class UiError implements UiErrorInterface
{
    /**
     * @param string $scope
     * @param string|null $path
     * @param string $text
     * @param string|null $code
     */
    public function __construct(
        private string  $scope,
        private ?string $path,
        private string  $text,
        private ?string $code = null,
    ) {
        if ($scope === '') { throw new \InvalidArgumentException('UiError scope must not be empty.'); }
        if ($text === '') { throw new \InvalidArgumentException('UiError text must not be empty.'); }
    }

    /**
     * @return string
     */
    public function scope(): string { return $this->scope; }

    /**
     * @return string|null
     */
    public function path(): ?string { return $this->path; }

    /**
     * @return string
     */
    public function text(): string { return $this->text; }

    /**
     * @return string|null
     */
    public function code(): ?string { return $this->code; }
}

