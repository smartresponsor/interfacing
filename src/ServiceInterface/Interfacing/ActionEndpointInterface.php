<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\ServiceInterface\Interfacing;

use App\Domain\Interfacing\Model\ActionRequest;
use App\Domain\Interfacing\Model\ActionResult;
use App\Domain\Interfacing\Value\ActionId;

interface ActionEndpointInterface
{
    public function id(): ActionId;
    public function handle(ActionRequest $request): ActionResult;
}
