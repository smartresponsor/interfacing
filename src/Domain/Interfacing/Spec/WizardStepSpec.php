    <?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\Domain\Interfacing\Spec;

    final class WizardStepSpec
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly FormSpec $form,
    ) {
    }
}

