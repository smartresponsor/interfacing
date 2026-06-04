<?php

declare(strict_types=1);

namespace App\Interfacing\Assembler\Context;

use App\Interfacing\AssemblerInterface\Context\InterfaceScreenContextAssemblerInterface;
use App\Interfacing\ProviderInterface\Context\InterfaceBaseContextProviderInterface;

final readonly class InterfaceScreenContextAssembler implements InterfaceScreenContextAssemblerInterface
{
    public function __construct(private InterfaceBaseContextProviderInterface $baseContextProvider)
    {
    }

    public function assemble(string $screenId): array
    {
        $context = $this->baseContextProvider->provide();
        $context['screenId'] = $screenId;

        return $context;
    }
}
