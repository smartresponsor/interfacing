<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\ServiceInterface\Interfacing\Context;

    use App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface;

    /**
     *
     */

    /**
     *
     */
    interface BaseContextProviderInterface
{
    /**
     * @return \App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface
     */
    public function provide(): ScreenContextInterface;
}

