<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action;

use SmartResponsor\Interfacing\Domain\Interfacing\Action\ActionResult;

/**
 * An action endpoint is a thin handler for a UI action (save, delete, sync, etc.).
 * It returns ActionResult which can update UI state without a SPA.
 */
interface ActionEndpointInterface
{
    /**
     * @param array<string, mixed> $payload
     */
    public function handle(array $payload): ActionResult;
}
