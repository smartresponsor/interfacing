<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Builder;

use App\Interfacing\BuilderInterface\InterfaceMetricSpecBuilderInterface;
use App\Interfacing\Contract\Spec\InterfaceMetricSpec;

final class InterfaceMetricSpecBuilder implements InterfaceMetricSpecBuilderInterface
{
    private ?string $hint = null;

    private function __construct(
        private readonly string $id,
        private readonly string $title,
        private string $value,
    ) {
    }

    public static function create(string $id, string $title, string $value): self
    {
        return new self($id, $title, $value);
    }

    /**
     * @return $this
     */
    public function hint(?string $hint): self
    {
        $this->hint = $hint;

        return $this;
    }

    /**
     * @return $this
     */
    public function value(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function build(): InterfaceMetricSpec
    {
        return new InterfaceMetricSpec($this->id, $this->title, $this->value, $this->hint);
    }
}
