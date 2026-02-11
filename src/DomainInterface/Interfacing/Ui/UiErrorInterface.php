<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\DomainInterface\Interfacing\Ui;

/**
 *
 */

/**
 *
 */
interface UiErrorInterface
{
    /**
     * @return string
     */
    public function scope(): string;

    /**
     * @return string|null
     */
    public function path(): ?string;

    /**
     * @return string
     */
    public function text(): string;

    /**
     * @return string|null
     */
    public function code(): ?string;
}

