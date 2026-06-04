<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Contract\Spec;

final readonly class InterfaceWizardSpec
{
    /** @var list<InterfaceWizardStepSpec> */
    public array $step;

    /**
     * @param list<InterfaceWizardStepSpec> $step
     */
    public function __construct(
        public string $id,
        public string $title,
        array $step,
    ) {
        $this->step = $step;
    }
}
