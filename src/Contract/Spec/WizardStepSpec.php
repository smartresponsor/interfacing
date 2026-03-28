<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Contract\Spec;

    final readonly class WizardStepSpec
{
    public function __construct(
        public string $id,
        public string $title,
        public FormSpec $form,
    ) {
    }
}
