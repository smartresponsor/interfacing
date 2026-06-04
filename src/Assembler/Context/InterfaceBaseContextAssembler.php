<?php

declare(strict_types=1);

namespace App\Interfacing\Assembler\Context;

use App\Interfacing\AssemblerInterface\Context\InterfaceBaseContextAssemblerInterface;
use App\Interfacing\ProviderInterface\Context\InterfaceBaseContextProviderInterface;

final readonly class InterfaceBaseContextAssembler implements InterfaceBaseContextAssemblerInterface
{
    /** @param iterable<InterfaceBaseContextProviderInterface> $provider */
    public function __construct(private iterable $provider)
    {
    }

    public function assemble(): array
    {
        $ctx = [];
        foreach ($this->provider as $p) {
            $data = $p->provide();
            foreach ($data as $k => $v) {
                $ctx[(string) $k] = $v;
            }
        }

        return $ctx;
    }
}
