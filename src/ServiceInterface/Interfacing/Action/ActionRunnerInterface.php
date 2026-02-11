<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\ServiceInterface\Interfacing\Action;

use App\Domain\Interfacing\Action\ActionRequest;
use App\Domain\Interfacing\Action\ActionResult;

/**
 *
 */

/**
 *
 */
interface ActionRunnerInterface
{
    /**
     * @param \App\Domain\Interfacing\Action\ActionRequest $request
     * @return \App\Domain\Interfacing\Action\ActionResult
     */
    public function run(ActionRequest $request): ActionResult;
}
