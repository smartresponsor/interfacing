<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\EndpointInterface\AttributeRegistry;

use App\Interfacing\Contract\Runtime\InterfaceActionRequest;
use App\Interfacing\Contract\Runtime\InterfaceActionResult;

interface InterfaceActionEndpointInterface
{
    public function screenId(): string;

    public function actionId(): string;

    public function title(): string;

    public function order(): int;

    public function handle(InterfaceActionRequest $request): InterfaceActionResult;
}
