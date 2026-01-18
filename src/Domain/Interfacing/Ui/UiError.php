<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\Domain\Interfacing\Ui;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Ui\UiErrorInterface;

final class UiError implements UiErrorInterface
{
    public function __construct(
        private readonly string $scope,
        private readonly ?string $path,
        private readonly string $text,
        private readonly ?string $code = null,
    ) {
        if ($scope === '') { throw new \InvalidArgumentException('UiError scope must not be empty.'); }
        if ($text === '') { throw new \InvalidArgumentException('UiError text must not be empty.'); }
    }

    public function scope(): string { return $this->scope; }
    public function path(): ?string { return $this->path; }
    public function text(): string { return $this->text; }
    public function code(): ?string { return $this->code; }
}

