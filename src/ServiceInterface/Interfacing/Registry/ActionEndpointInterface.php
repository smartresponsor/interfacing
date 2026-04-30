<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\ServiceInterface\Interfacing\Registry;

use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionRequest;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionResult;

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
     * @param \App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionRequest $request
     * @return \App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionResult
     */
    public function handle(ActionRequest $request): ActionResult;
}
