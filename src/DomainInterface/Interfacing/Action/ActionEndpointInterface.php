<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\DomainInterface\Interfacing\Action;

use App\Domain\Interfacing\Action\ActionRequest;
use App\Domain\Interfacing\Action\ActionResult;

/**
 *
 */

/**
 *
 */
interface ActionEndpointInterface
{
    /**
     * @return string
     */
    public function actionId(): string;

    /**
     * @param \App\Domain\Interfacing\Action\ActionRequest $request
     * @return \App\Domain\Interfacing\Action\ActionResult
     */
    public function handle(ActionRequest $request): ActionResult;
}
