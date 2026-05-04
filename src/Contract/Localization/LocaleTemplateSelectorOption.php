<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Localization;

/**
 * Locale selector option consumed by Interfacing shell views.
 *
 * This contract intentionally belongs to Interfacing so the component can render
 * locale-aware chrome without autoloading a sibling Localizing repository. Host
 * applications may adapt richer Localizing value objects into this shape.
 */
final readonly class LocaleTemplateSelectorOption
{
    public function __construct(
        public string $code,
        public string $name,
        public string $nativeName,
        public bool $current = false,
        public bool $default = false,
    ) {
    }
}
