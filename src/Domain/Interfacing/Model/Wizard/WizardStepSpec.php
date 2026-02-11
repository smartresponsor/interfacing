<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Wizard;

use App\Domain\Interfacing\Model\Form\FormFieldSpec;

/**
 *
 */

/**
 *
 */
final class WizardStepSpec
{
    /** @param list<FormFieldSpec> $field */
    public function __construct(
        private string          $id,
        private readonly string $title,
        private readonly array  $field,
        private string          $hint = '',
    ) {
        $this->id = trim($this->id);
        if ($this->id === '') { throw new \InvalidArgumentException('WizardStepSpec id must be non-empty.'); }
        if ($this->field === []) { throw new \InvalidArgumentException('WizardStepSpec field must be non-empty.'); }
        $this->hint = trim($this->hint);
    }

    /**
     * @return string
     */
    public function id(): string { return $this->id; }

    /**
     * @return string
     */
    public function title(): string { return $this->title; }

    /**
     * @return string
     */
    public function hint(): string { return $this->hint; }

    /** @return list<FormFieldSpec> */
    public function field(): array { return $this->field; }
}
