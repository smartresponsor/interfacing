<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Service\Interfacing\Builder;

    use App\Domain\Interfacing\Spec\FormSpec;
use App\Domain\Interfacing\Spec\WizardSpec;
use App\Domain\Interfacing\Spec\WizardStepSpec;
use App\ServiceInterface\Interfacing\Builder\WizardSpecBuilderInterface;

    /**
     *
     */

    /**
     *
     */
    final class WizardSpecBuilder implements WizardSpecBuilderInterface
{
    /** @var list<WizardStepSpec> */
    private array $step = [];

    /**
     * @param string $id
     * @param string $title
     */
    private function __construct(
        private readonly string $id,
        private readonly string $title,
    ) {
    }

    /**
     * @param string $id
     * @param string $title
     * @return self
     */
    public static function create(string $id, string $title): self
    {
        return new self($id, $title);
    }

    /**
     * @param string $id
     * @param string $title
     * @param \App\Domain\Interfacing\Spec\FormSpec $form
     * @return $this
     */
    public function step(string $id, string $title, FormSpec $form): self
    {
        $this->step[] = new WizardStepSpec($id, $title, $form);
        return $this;
    }

    /**
     * @return \App\Domain\Interfacing\Spec\WizardSpec
     */
    public function build(): WizardSpec
    {
        return new WizardSpec($this->id, $this->title, $this->step);
    }
}

