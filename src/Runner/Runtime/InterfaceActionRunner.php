<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Runner\Runtime;

use App\Interfacing\CatalogInterface\AttributeRegistry\InterfaceActionCatalogInterface;
use App\Interfacing\Contract\Runtime\InterfaceActionRequest;
use App\Interfacing\Contract\Runtime\InterfaceActionResult;
use App\Interfacing\RunnerInterface\Runtime\InterfaceActionRunnerInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class InterfaceActionRunner implements InterfaceActionRunnerInterface
{
    public function __construct(
        private InterfaceActionCatalogInterface $actionCatalog,
    ) {
    }

    public function run(string $screenId, string $actionId, array $payload, Request $request): InterfaceActionResult
    {
        $endpoint = $this->actionCatalog->get($screenId, $actionId);

        return $endpoint->handle(new InterfaceActionRequest($screenId, $actionId, $payload, $request));
    }
}
