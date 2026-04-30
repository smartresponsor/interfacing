<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Interfacing\Ui;

use App\Interfacing\Contract\Ui\UiErrorBag;

interface ValidationRunnerInterface
{
    /**
     * @param object        $input an input DTO with Symfony Validator constraints
     * @param string[]|null $group validation groups; null means default group
     */
    public function validate(object $input, ?array $group = null): UiErrorBag;
}
