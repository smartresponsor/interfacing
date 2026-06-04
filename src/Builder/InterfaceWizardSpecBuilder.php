<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Builder;

use App\Interfacing\BuilderInterface\InterfaceWizardSpecBuilderInterface;
use App\Interfacing\Contract\Spec\InterfaceFormSpec;
use App\Interfacing\Contract\Spec\InterfaceWizardSpec;
use App\Interfacing\Contract\Spec\InterfaceWizardStepSpec;

final class InterfaceWizardSpecBuilder implements InterfaceWizardSpecBuilderInterface
{
    /** @var list<InterfaceWizardStepSpec> */
    private array $step = [];

    private function __construct(
        private readonly string $id,
        private readonly string $title,
    ) {
    }

    public static function create(string $id, string $title): self
    {
        return new self($id, $title);
    }

    /**
     * @return $this
     */
    public function step(string $id, string $title, InterfaceFormSpec $form): self
    {
        $this->step[] = new InterfaceWizardStepSpec($id, $title, $form);

        return $this;
    }

    public function build(): InterfaceWizardSpec
    {
        return new InterfaceWizardSpec($this->id, $this->title, $this->step);
    }
}
