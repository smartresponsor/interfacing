<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Service\Interfacing\Builder;

use App\Contract\Spec\FormFieldSpec;
use App\Contract\Spec\FormSpec;
use App\ServiceInterface\Interfacing\Builder\FormSpecBuilderInterface;

final class FormSpecBuilder implements FormSpecBuilderInterface
{
    /** @var list<FormFieldSpec> */
    private array $field = [];

    private function __construct(
        private readonly string $id,
    ) {
    }

    public static function create(string $id): self
    {
        return new self($id);
    }

    /**
     * @return $this
     */
    public function text(string $name, string $label, bool $required = false, ?string $placeholder = null): self
    {
        $this->field[] = new FormFieldSpec($name, 'text', $label, $required, $placeholder);

        return $this;
    }

    /**
     * @return $this
     */
    public function slug(string $name, string $label, bool $required = false, ?string $placeholder = null): self
    {
        $this->field[] = new FormFieldSpec($name, 'slug', $label, $required, $placeholder);

        return $this;
    }

    /**
     * @param array<string, scalar|null> $option
     */
    public function select(string $name, string $label, array $option, bool $required = false): self
    {
        $this->field[] = new FormFieldSpec($name, 'select', $label, $required, null, $option);

        return $this;
    }

    /**
     * @return $this
     */
    public function submit(string $name, string $label = 'Submit'): self
    {
        $this->field[] = new FormFieldSpec($name, 'submit', $label, false);

        return $this;
    }

    public function build(): FormSpec
    {
        return new FormSpec($this->id, $this->field);
    }
}
