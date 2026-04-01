<?php

declare(strict_types=1);

namespace App\Contract\View;

use App\Contract\Zone\UiZone;

final readonly class UiProviderBinding
{
    public function __construct(
        private UiZone $zone,
        private string $provider,
        private string $wrapper,
        private ?string $surface = null,
        private ?string $density = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'zone' => $this->zone->value,
            'provider' => $this->provider,
            'wrapper' => $this->wrapper,
            'surface' => $this->surface,
            'density' => $this->density,
        ];
    }
}
