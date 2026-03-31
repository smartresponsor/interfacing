<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Presentation\LiveComponent\Interfacing\Widget\Form;

use App\Contract\View\FormSpec;

interface FormWidgetComponentInterface
{
    public function spec(): FormSpec;

    public function fieldValue(string $id): mixed;

    public function fieldErrorFor(string $id): string;
}
