<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Builder;

use App\Interfacing\BuilderInterface\InterfaceFormSpecBuilderInterface;
use App\Interfacing\Contract\Spec\InterfaceFormFieldSpec;
use App\Interfacing\Contract\Spec\InterfaceFormSpec;

final class InterfaceFormSpecBuilder implements InterfaceFormSpecBuilderInterface
{
    /** @var list<InterfaceFormFieldSpec> */
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
        $this->field[] = new InterfaceFormFieldSpec($name, 'text', $label, $required, $placeholder);

        return $this;
    }

    /**
     * @return $this
     */
    public function slug(string $name, string $label, bool $required = false, ?string $placeholder = null): self
    {
        $this->field[] = new InterfaceFormFieldSpec($name, 'slug', $label, $required, $placeholder);

        return $this;
    }

    /**
     * @param array<string, scalar|null> $option
     */
    public function select(string $name, string $label, array $option, bool $required = false): self
    {
        $this->field[] = new InterfaceFormFieldSpec($name, 'select', $label, $required, null, $option);

        return $this;
    }

    /**
     * @return $this
     */
    public function submit(string $name, string $label = 'Submit'): self
    {
        $this->field[] = new InterfaceFormFieldSpec($name, 'submit', $label, false);

        return $this;
    }

    public function build(): InterfaceFormSpec
    {
        return new InterfaceFormSpec($this->id, $this->field);
    }
}
