<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Domain\Interfacing\Spec;

    /**
     *
     */

    /**
     *
     */
    final readonly class WizardStepSpec
{
        /**
         * @param string $id
         * @param string $title
         * @param \App\Domain\Interfacing\Spec\FormSpec $form
         */
        public function __construct(
        public string   $id,
        public string   $title,
        public FormSpec $form,
    ) {
    }
}

