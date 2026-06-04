<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Localization;

/**
 * Locale selector context consumed by Interfacing screen providers.
 */
final readonly class InterfaceLocaleTemplateContext
{
    /**
     * @param list<string>                                $fallbackLocaleCodes
     * @param list<InterfaceLocaleTemplateSelectorOption> $selectorOptions
     */
    public function __construct(
        public string $currentLocaleCode,
        public string $defaultLocaleCode,
        public array $fallbackLocaleCodes,
        public array $selectorOptions,
    ) {
    }
}
