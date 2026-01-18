    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Context;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Context\ScreenContextInterface;

interface BaseContextProviderInterface
{
    public function provide(): ScreenContextInterface;
}

