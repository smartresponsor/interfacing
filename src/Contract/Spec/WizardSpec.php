<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Contract\Spec;

final readonly class WizardSpec
{
    /** @var list<WizardStepSpec> */
    public array $step;

    /**
     * @param list<WizardStepSpec> $step
     */
    public function __construct(
        public string $id,
        public string $title,
        array $step,
    ) {
        $this->step = $step;
    }
}
