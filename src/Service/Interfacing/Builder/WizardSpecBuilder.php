<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Interfacing\Service\Interfacing\Builder;

use App\Interfacing\Contract\Spec\FormSpec;
use App\Interfacing\Contract\Spec\WizardSpec;
use App\Interfacing\Contract\Spec\WizardStepSpec;
use App\Interfacing\ServiceInterface\Interfacing\Builder\WizardSpecBuilderInterface;

final class WizardSpecBuilder implements WizardSpecBuilderInterface
{
    /** @var list<WizardStepSpec> */
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
    public function step(string $id, string $title, FormSpec $form): self
    {
        $this->step[] = new WizardStepSpec($id, $title, $form);

        return $this;
    }

    public function build(): WizardSpec
    {
        return new WizardSpec($this->id, $this->title, $this->step);
    }
}
