<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\ServiceInterface\Interfacing\Registry;

use App\ServiceInterface\Interfacing\Runtime\ActionRequest;
use App\ServiceInterface\Interfacing\Runtime\ActionResult;

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
    public function screenId(): string;

    /**
     * @return string
     */
    public function actionId(): string;

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return int
     */
    public function order(): int;

    /**
     * @param \App\ServiceInterface\Interfacing\Runtime\ActionRequest $request
     * @return \App\ServiceInterface\Interfacing\Runtime\ActionResult
     */
    public function handle(ActionRequest $request): ActionResult;
}
