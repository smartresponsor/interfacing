<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Localization;

use App\Interfacing\Contract\Localization\LocaleTemplateSelectorOption;

interface LocaleTemplateSelectorProviderInterface
{
    /**
     * @return list<LocaleTemplateSelectorOption>
     */
    public function provide(string $currentLocaleCode): array;
}
