<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Runtime\Context;

use App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;
use App\ServiceInterface\Interfacing\Runtime\BaseContextProviderInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenContextResolverInterface;

/**
 *
 */

/**
 *
 */
final class ScreenContextAssembler implements ScreenContextAssemblerInterface
{
    /**
     * @param iterable<ScreenContextResolverInterface> $resolver
     */
    public function __construct(
        private readonly BaseContextProviderInterface $base,
        private readonly iterable                     $resolver,
    ) {
    }

    /**
     * @param \App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface $spec
     * @return array|mixed[]
     */
    public function contextFor(LayoutScreenSpecInterface $spec): array
    {
        $ctx = $this->base->context();
        $ctx['layoutId'] = $spec->id();
        $ctx['screenId'] = $spec->screenId()->toString();

        foreach ($this->resolver as $r) {
            if (!$r->supports($spec)) {
                continue;
            }
            $ctx = $r->resolve($spec, $ctx);
        }

        return $ctx;
    }
}
