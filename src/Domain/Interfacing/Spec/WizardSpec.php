<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Domain\Interfacing\Spec;

    final class WizardSpec
{
    /** @var list<WizardStepSpec> */
    public readonly array $step;

    /**
     * @param list<WizardStepSpec> $step
     */
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        array $step,
    ) {
        $this->step = $step;
    }
}

