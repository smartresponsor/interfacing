<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\HandlerInterface\Widget\Wizard;

use App\Interfacing\Contract\Dto\InterfaceFormSubmitResult;
use App\Interfacing\Contract\View\InterfaceWizardSpec;

interface InterfaceWizardHandlerInterface
{
    public function id(): string;

    public function spec(array $context = []): InterfaceWizardSpec;

    /** @return array<string,mixed> */
    public function initialValue(array $context = []): array;

    /** @param array<string,mixed> $value */
    public function validateStep(string $stepId, array $value, array $context = []): InterfaceFormSubmitResult;

    /** @param array<string,mixed> $value */
    public function finish(array $value, array $context = []): InterfaceFormSubmitResult;
}
