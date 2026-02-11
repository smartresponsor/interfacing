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
interface UiMessageInterface
{
    /**
     * @return string
     */
    public function type(): string;

    /**
     * @return string
     */
    public function text(): string;

    /**
     * @return string|null
     */
    public function code(): ?string;
}

