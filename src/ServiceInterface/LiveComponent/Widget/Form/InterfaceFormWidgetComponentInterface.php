<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\LiveComponent\Widget\Form;

use App\Interfacing\Contract\View\InterfaceFormSpec;

interface InterfaceFormWidgetComponentInterface
{
    public function spec(): InterfaceFormSpec;

    public function fieldValue(string $id): mixed;

    public function fieldErrorFor(string $id): string;
}
