<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Runtime\Context;

use App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenContextResolverInterface;

/**
 *
 */

/**
 *
 */
final class DemoScreenContextResolver implements ScreenContextResolverInterface
{
    /**
     * @return string
     */
    public function id(): string
    {
        return 'demo';
    }

    /**
     * @param \App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface $spec
     * @return bool
     */
    public function supports(LayoutScreenSpecInterface $spec): bool
    {
        return str_starts_with($spec->id(), 'metrics-') || str_starts_with($spec->id(), 'form-') || str_starts_with($spec->id(), 'wizard-');
    }

    /**
     * @param \App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface $spec
     * @param array $context
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
