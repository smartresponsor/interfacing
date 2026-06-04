<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Localization;

use App\Interfacing\Contract\Localization\InterfaceLocaleTemplateSelectorOption;

interface InterfaceLocaleTemplateSelectorProviderInterface
{
    /**
     * @return list<InterfaceLocaleTemplateSelectorOption>
     */
    public function provide(string $currentLocaleCode): array;
}
