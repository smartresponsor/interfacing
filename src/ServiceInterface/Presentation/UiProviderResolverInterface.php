<?php

declare(strict_types=1);

namespace App\ServiceInterface\Presentation;

use App\Contract\View\UiProviderBinding;
use App\Contract\Zone\UiZone;

interface UiProviderResolverInterface
{
    public function forZone(UiZone $zone): UiProviderBinding;
}
