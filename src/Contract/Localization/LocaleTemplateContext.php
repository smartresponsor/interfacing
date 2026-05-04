<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Localization;

/**
 * Locale selector context consumed by Interfacing screen providers.
 */
final readonly class LocaleTemplateContext
{
    /**
     * @param list<string> $fallbackLocaleCodes
     * @param list<LocaleTemplateSelectorOption> $selectorOptions
     */
    public function __construct(
        public string $currentLocaleCode,
        public string $defaultLocaleCode,
        public array $fallbackLocaleCodes,
        public array $selectorOptions,
    ) {
    }
}
