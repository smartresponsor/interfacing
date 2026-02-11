<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Form;

/**
 *
 */

/**
 *
 */
final class FormSpec
{
    /**
     * @param list<FormFieldSpec> $field
     */
    public function __construct(
        private string          $id,
        private readonly string $title,
        private readonly array  $field,
        private string          $submitLabel = 'Submit',
        private string          $hint = '',
    ) {
        $this->id = trim($this->id);
        if ($this->id === '') {
            throw new \InvalidArgumentException('FormSpec id must be non-empty.');
        }
        if ($this->field === []) {
            throw new \InvalidArgumentException('FormSpec field must be non-empty.');
        }
        $this->submitLabel = trim($this->submitLabel) !== '' ? trim($this->submitLabel) : 'Submit';
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

    /** @return list<FormFieldSpec> */
    public function field(): array { return $this->field; }

    /**
     * @return string
     */
    public function submitLabel(): string { return $this->submitLabel; }

    /**
     * @return string
     */
    public function hint(): string { return $this->hint; }
}
