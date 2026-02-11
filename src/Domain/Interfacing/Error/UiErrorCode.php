<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Domain\Interfacing\Error;

/**
 *
 */

/**
 *
 */
final class UiErrorCode
{
    public const VALIDATION = 'ui.validation';
    public const FORBIDDEN = 'ui.forbidden';
    public const NOT_FOUND = 'ui.not-found';
    public const UNAVAILABLE = 'ui.unavailable';
    public const TIMEOUT = 'ui.timeout';
    public const UNEXPECTED = 'ui.unexpected';
}
