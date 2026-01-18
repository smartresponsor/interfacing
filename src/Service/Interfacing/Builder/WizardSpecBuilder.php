<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\Service\Interfacing\Builder;

    use SmartResponsor\Interfacing\Domain\Interfacing\Spec\FormSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Spec\WizardSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Spec\WizardStepSpec;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Builder\WizardSpecBuilderInterface;

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

