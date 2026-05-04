<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Localization;

use App\Interfacing\Contract\Localization\LocaleTemplateContext;

interface LocaleTemplateContextProviderInterface
{
    public function provide(string $currentLocaleCode): LocaleTemplateContext;
}
