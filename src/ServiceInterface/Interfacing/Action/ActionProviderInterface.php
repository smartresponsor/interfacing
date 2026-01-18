<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\ServiceInterface\Interfacing\Action;

use SmartResponsor\DomainInterface\Interfacing\Action\ActionEndpointInterface;

interface ActionProviderInterface
{
    /** @return array<int, ActionEndpointInterface> */
    public function provide(): array;
}

