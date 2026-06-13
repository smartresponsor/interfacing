<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Localization;

use App\Interfacing\Contract\Localization\InterfaceLocaleTemplateSelectorOption;
use App\Interfacing\ProviderInterface\Localization\InterfaceLocaleTemplateSelectorProviderInterface;

/**
 * Standalone Interfacing locale selector provider.
 */
final readonly class InterfaceDefaultLocaleTemplateSelectorProvider implements InterfaceLocaleTemplateSelectorProviderInterface
{
    /**
     * @return list<InterfaceLocaleTemplateSelectorOption>
     */
    public function provide(string $currentLocaleCode): array
    {
        $currentLocaleCode = $this->normalizeLocale($currentLocaleCode);
        $known = [
            ['en', 'English', 'English'],
            ['uk', 'Ukrainian', 'Українська'],
            ['es', 'Spanish', 'Español'],
        ];

        $options = [];
        foreach ($known as [$code, $nameEntity, $nativeName]) {
            $options[] = new InterfaceLocaleTemplateSelectorOption(
                $code,
                $nameEntity,
                $nativeName,
                $code === $currentLocaleCode,
                'en' === $code,
            );
        }

        return $options;
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
