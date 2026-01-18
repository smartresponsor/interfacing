<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Provider;

    use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action\ActionEndpointInterface;

interface ActionProviderInterface
{
    /** @return array<int, ActionEndpointInterface> */
    public function provide(): array;
}

