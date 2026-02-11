<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Wizard;

/**
 *
 */

/**
 *
 */
final class WizardSpec
{
    /** @param list<WizardStepSpec> $step */
    public function __construct(
        private string          $id,
        private readonly string $title,
        private readonly array  $step,
        private string          $finishLabel = 'Finish',
        private string          $cancelLabel = 'Cancel',
    ) {
        $this->id = trim($this->id);
        if ($this->id === '') { throw new \InvalidArgumentException('WizardSpec id must be non-empty.'); }
        if ($this->step === []) { throw new \InvalidArgumentException('WizardSpec step must be non-empty.'); }
        $this->finishLabel = trim($this->finishLabel) !== '' ? trim($this->finishLabel) : 'Finish';
        $this->cancelLabel = trim($this->cancelLabel) !== '' ? trim($this->cancelLabel) : 'Cancel';
    }

    /**
     * @return string
     */
    public function id(): string { return $this->id; }

    /**
     * @return string
     */
    public function title(): string { return $this->title; }

    /** @return list<WizardStepSpec> */
    public function step(): array { return $this->step; }

    /**
     * @return string
     */
    public function finishLabel(): string { return $this->finishLabel; }

    /**
     * @return string
     */
    public function cancelLabel(): string { return $this->cancelLabel; }
}
