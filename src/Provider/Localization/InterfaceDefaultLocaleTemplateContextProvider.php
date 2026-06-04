<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Localization;

use App\Interfacing\Contract\Localization\InterfaceLocaleTemplateContext;
use App\Interfacing\ProviderInterface\Localization\InterfaceLocaleTemplateContextProviderInterface;

/**
 * Standalone Interfacing locale context provider.
 *
 * Host applications can override this service with an adapter backed by
 * Localizing, Intl, database settings, or tenant configuration. The default
 * implementation keeps Interfacing bundle-usable without a sibling checkout.
 */
final readonly class InterfaceDefaultLocaleTemplateContextProvider implements InterfaceLocaleTemplateContextProviderInterface
{
    public function __construct(
        private InterfaceDefaultLocaleTemplateSelectorProvider $selectorProvider,
    ) {
    }

    public function provide(string $currentLocaleCode): InterfaceLocaleTemplateContext
    {
        $currentLocaleCode = $this->normalizeLocale($currentLocaleCode);

        return new InterfaceLocaleTemplateContext(
            $currentLocaleCode,
            'en',
            array_values(array_unique([$currentLocaleCode, 'en'])),
            $this->selectorProvider->provide($currentLocaleCode),
        );
    }

    private function normalizeLocale(string $localeCode): string
    {
        $localeCode = strtolower(trim($localeCode));
        $localeCode = str_replace('_', '-', $localeCode);

        if ('' === $localeCode) {
            return 'en';
        }

        return explode('-', $localeCode)[0] ?: 'en';
    }
}
