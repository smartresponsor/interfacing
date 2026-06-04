<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

final class InterfaceWizardSpec
{
    /** @param list<InterfaceWizardStepSpec> $step */
    public function __construct(
        private string $id,
        private readonly string $title,
        private readonly array $step,
        private string $finishLabel = 'Finish',
        private string $cancelLabel = 'Cancel',
    ) {
        $this->id = trim($this->id);
        if ('' === $this->id) {
            throw new \InvalidArgumentException('InterfaceWizardSpec id must be non-empty.');
        }
        if ([] === $this->step) {
            throw new \InvalidArgumentException('InterfaceWizardSpec step must be non-empty.');
        }
        $this->finishLabel = '' !== trim($this->finishLabel) ? trim($this->finishLabel) : 'Finish';
        $this->cancelLabel = '' !== trim($this->cancelLabel) ? trim($this->cancelLabel) : 'Cancel';
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    /** @return list<InterfaceWizardStepSpec> */
    public function step(): array
    {
        return $this->step;
    }

    public function finishLabel(): string
    {
        return $this->finishLabel;
    }

    public function cancelLabel(): string
    {
        return $this->cancelLabel;
    }
}
