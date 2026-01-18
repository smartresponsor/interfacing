<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Action;

use SmartResponsor\Interfacing\Domain\Interfacing\Action\ActionRequest;
use SmartResponsor\Interfacing\Domain\Interfacing\Action\ActionResult;

interface ActionEndpointInterface
{
    public function actionId(): string;

    public function handle(ActionRequest $request): ActionResult;
}
