<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Twig;

use App\Interfacing\Registry\Style\InterfaceStyleProviderRegistry;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class InterfaceStyleProviderTwigExtension extends AbstractExtension
{
    public function __construct(
        private readonly InterfaceStyleProviderRegistry $styleProviderRegistry,
    ) {
    }

    /**
     * @return list<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('interface_style_provider', [$this, 'provider']),
            new TwigFunction('interface_style_provider_keys', [$this->styleProviderRegistry, 'keys']),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function provider(?string $key = null): array
    {
        return $this->styleProviderRegistry->get($key ?: 'ant_design')->manifest();
    }
}
