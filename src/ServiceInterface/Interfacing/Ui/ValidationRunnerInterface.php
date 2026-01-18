<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Ui;

use App\Domain\Interfacing\Ui\UiErrorBag;

interface ValidationRunnerInterface
{
    /**
     * @param object $input An input DTO with Symfony Validator constraints.
     * @param string[]|null $group Validation groups; null means default group.
     */
    public function validate(object $input, ?array $group = null): UiErrorBag;
}
