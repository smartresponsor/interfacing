<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\ServiceInterface\Interfacing\Provider;

    use App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;

    /**
     *
     */

    /**
     *
     */
    interface ScreenProviderInterface
{
    /** @return array<int, ScreenSpecInterface> */
    public function provide(): array;
}

