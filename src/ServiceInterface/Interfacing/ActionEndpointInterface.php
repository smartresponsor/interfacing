<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\ActionRequest;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\ActionResult;
use SmartResponsor\Interfacing\Domain\Interfacing\Value\ActionId;

interface ActionEndpointInterface
{
    public function id(): ActionId;
    public function handle(ActionRequest $request): ActionResult;
}
