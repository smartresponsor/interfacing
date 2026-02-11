<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\ServiceInterface\Interfacing\Registry;

    interface ActionCatalogInterface
{
    /**
     * @return list<ActionEndpointInterface>
     */
    public function allForScreen(string $screenId): array;

    public function get(string $screenId, string $actionId): ActionEndpointInterface;
}

