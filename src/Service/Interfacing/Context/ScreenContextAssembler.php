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

    /**
     *
     */

    /**
     *
     */
    final readonly class ScreenContextAssembler implements ScreenContextAssemblerInterface
{
    /**
     * @param \App\ServiceInterface\Interfacing\Context\BaseContextProviderInterface $baseContextProvider
     */
    public function __construct(
        private BaseContextProviderInterface $baseContextProvider,
    ) {}

    /**
     * @param string $screenId
     * @return \App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface
     */
    public function assemble(string $screenId): ScreenContextInterface
    {
        return $this->baseContextProvider->provide();
    }
}

