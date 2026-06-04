<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Localization;

use App\Interfacing\Contract\Localization\InterfaceLocaleTemplateContext;

interface InterfaceLocaleTemplateContextProviderInterface
{
    public function provide(string $currentLocaleCode): InterfaceLocaleTemplateContext;
}
