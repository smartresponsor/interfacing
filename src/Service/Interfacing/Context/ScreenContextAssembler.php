    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Service\Interfacing\Context;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Context\ScreenContextInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Context\BaseContextProviderInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Context\ScreenContextAssemblerInterface;

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

