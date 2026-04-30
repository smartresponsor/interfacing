<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Interfacing\Runtime\Context;

use App\Interfacing\Contract\View\LayoutScreenSpecInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenContextResolverInterface;

final class DemoScreenContextResolver implements ScreenContextResolverInterface
{
    public function id(): string
    {
        return 'demo';
    }

    public function supports(LayoutScreenSpecInterface $spec): bool
    {
        return str_starts_with($spec->id(), 'metrics-') || str_starts_with($spec->id(), 'form-') || str_starts_with($spec->id(), 'wizard-');
    }

    /**
     * @return array|mixed[]
     */
    public function resolve(LayoutScreenSpecInterface $spec, array $context): array
    {
        $context['demo'] = [
            'layoutId' => $spec->id(),
            'screenId' => $spec->screenId()->toString(),
            'seed' => substr(hash('sha256', $spec->id().'|'.$spec->screenId()->toString()), 0, 12),
        ];

        return $context;
    }
}
