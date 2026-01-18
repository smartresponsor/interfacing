<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Service\Interfacing\Runtime\Context;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\BaseContextProviderInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenContextResolverInterface;

final class ScreenContextAssembler implements ScreenContextAssemblerInterface
{
    /**
     * @param iterable<ScreenContextResolverInterface> $resolver
     */
    public function __construct(
        private BaseContextProviderInterface $base,
        private iterable $resolver,
    ) {
    }

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
