<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\BuilderInterface\View;

interface InterfaceCrudExplorerViewBuilderInterface
{
    /** @return array<string, mixed> */
    public function buildPage(): array;

    /** @return array<string, mixed> */
    public function buildLinksPayload(): array;

    /** @return array<string, mixed> */
    public function buildRouteExpectationsPayload(): array;

    /** @return array<string, mixed> */
    public function buildOperationsPayload(): array;
}
