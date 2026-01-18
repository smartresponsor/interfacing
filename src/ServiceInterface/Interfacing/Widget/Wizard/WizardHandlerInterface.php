<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\Wizard;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Wizard\WizardSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\Form\FormSubmitResult;

interface WizardHandlerInterface
{
    public function id(): string;

    public function spec(array $context = []): WizardSpec;

    /** @return array<string,mixed> */
    public function initialValue(array $context = []): array;

    /** @param array<string,mixed> $value */
    public function validateStep(string $stepId, array $value, array $context = []): FormSubmitResult;

    /** @param array<string,mixed> $value */
    public function finish(array $value, array $context = []): FormSubmitResult;
}
