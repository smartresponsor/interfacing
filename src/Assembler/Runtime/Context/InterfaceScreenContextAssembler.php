<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Assembler\Runtime\Context;

use App\Interfacing\AssemblerInterface\Runtime\InterfaceScreenContextAssemblerInterface;
use App\Interfacing\Contract\View\InterfaceLayoutScreenSpecInterface;
use App\Interfacing\ProviderInterface\Runtime\InterfaceBaseContextProviderInterface;
use App\Interfacing\ResolverInterface\Runtime\InterfaceScreenContextResolverInterface;

final class InterfaceScreenContextAssembler implements InterfaceScreenContextAssemblerInterface
{
    /**
     * @param iterable<InterfaceScreenContextResolverInterface> $resolver
     */
    public function __construct(
        private readonly InterfaceBaseContextProviderInterface $base,
        private readonly iterable $resolver,
    ) {
    }

    /**
     * @return array|mixed[]
     */
    public function contextFor(InterfaceLayoutScreenSpecInterface $spec): array
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
