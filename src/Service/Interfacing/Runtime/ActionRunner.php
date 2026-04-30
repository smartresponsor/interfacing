<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Service\Interfacing\Runtime;

use App\Interfacing\ServiceInterface\Interfacing\Registry\ActionCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionRequest;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionResult;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionRunnerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */

/**
 *
 */
final readonly class ActionRunner implements ActionRunnerInterface
{
    /**
     * @param \App\Interfacing\ServiceInterface\Interfacing\Registry\ActionCatalogInterface $actionCatalog
     */
    public function __construct(
        private ActionCatalogInterface $actionCatalog,
    ) {
    }

    /**
     * @param string $screenId
     * @param string $actionId
     * @param array $payload
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionResult
     */
    public function run(string $screenId, string $actionId, array $payload, Request $request): ActionResult
    {
        $endpoint = $this->actionCatalog->get($screenId, $actionId);
        return $endpoint->handle(new ActionRequest($screenId, $actionId, $payload, $request));
    }
}
