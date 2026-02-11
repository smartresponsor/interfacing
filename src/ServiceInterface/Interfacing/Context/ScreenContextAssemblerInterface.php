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
    interface ScreenContextAssemblerInterface
{
    /**
     * @param string $screenId
     * @return \App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface
     */
    public function assemble(string $screenId): ScreenContextInterface;
}

