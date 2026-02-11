<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Service\Interfacing\Context;

    use App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface;
use App\ServiceInterface\Interfacing\Context\BaseContextProviderInterface;
use App\ServiceInterface\Interfacing\Context\ScreenContextAssemblerInterface;

final class ScreenContextAssembler implements ScreenContextAssemblerInterface
{
    public function __construct(
        private readonly BaseContextProviderInterface $baseContextProvider,
    ) {}

    public function assemble(string $screenId): ScreenContextInterface
    {
        return $this->baseContextProvider->provide();
    }
}

