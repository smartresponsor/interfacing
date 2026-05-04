<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Runtime\Provider;

use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenProviderInterface;

final class LocaleSelectorScreenProvider implements ScreenProviderInterface
{
    public function id(): string
    {
        return 'localizing';
    }

    public function map(): array
    {
        return [
            'localizing.locale.selector' => 'interfacing_screen',
        ];
    }
}
