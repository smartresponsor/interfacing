<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Localization;

use App\Interfacing\Contract\Localization\LocaleTemplateSelectorOption;
use App\Interfacing\ServiceInterface\Interfacing\Localization\LocaleTemplateSelectorProviderInterface;

/**
 * Standalone Interfacing locale selector provider.
 */
final readonly class DefaultLocaleTemplateSelectorProvider implements LocaleTemplateSelectorProviderInterface
{
    /**
     * @return list<LocaleTemplateSelectorOption>
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
        foreach ($known as [$code, $name, $nativeName]) {
            $options[] = new LocaleTemplateSelectorOption(
                $code,
                $name,
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
