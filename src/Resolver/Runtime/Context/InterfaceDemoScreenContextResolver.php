<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Resolver\Runtime\Context;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpecInterface;
use App\Interfacing\ResolverInterface\Runtime\InterfaceScreenContextResolverInterface;

final class InterfaceDemoScreenContextResolver implements InterfaceScreenContextResolverInterface
{
    public function id(): string
    {
        return 'demo';
    }

    public function supports(InterfaceLayoutScreenSpecInterface $spec): bool
    {
        return str_starts_with($spec->id(), 'metrics-') || str_starts_with($spec->id(), 'form-') || str_starts_with($spec->id(), 'wizard-');
    }

    /**
     * @return array|mixed[]
     */
    public function resolve(InterfaceLayoutScreenSpecInterface $spec, array $context): array
    {
        $context['demo'] = [
            'layoutId' => $spec->id(),
            'screenId' => $spec->screenId()->toString(),
            'seed' => substr(hash('sha256', $spec->id().'|'.$spec->screenId()->toString()), 0, 12),
        ];

        return $context;
    }
}
