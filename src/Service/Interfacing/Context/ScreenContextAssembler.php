<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Context;

use App\ServiceInterface\Interfacing\Context\BaseContextProviderInterface;
use App\ServiceInterface\Interfacing\Context\ScreenContextAssemblerInterface;

final readonly class ScreenContextAssembler implements ScreenContextAssemblerInterface
{
    public function __construct(private BaseContextProviderInterface $baseContextProvider)
    {
    }

    public function assemble(string $screenId): array
    {
        $context = $this->baseContextProvider->provide();
        $context['screenId'] = $screenId;

        return $context;
    }
}
