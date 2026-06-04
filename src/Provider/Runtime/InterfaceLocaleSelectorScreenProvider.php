<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Runtime;

use App\Interfacing\ProviderInterface\Runtime\InterfaceScreenProviderInterface;

final class InterfaceLocaleSelectorScreenProvider implements InterfaceScreenProviderInterface
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
