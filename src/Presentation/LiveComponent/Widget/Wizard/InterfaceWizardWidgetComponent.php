<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Widget\Wizard;

use App\Interfacing\Contract\View\InterfaceWizardProgress;
use App\Interfacing\Contract\View\InterfaceWizardSpec;
use App\Interfacing\Contract\View\InterfaceWizardStepSpec;
use App\Interfacing\RegistryInterface\Widget\Wizard\InterfaceWizardHandlerRegistryInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_widget_wizard', template: 'widget/wizard/wizard.html.twig')]
final class InterfaceWizardWidgetComponent
{
    #[LiveProp]
    public string $handlerId = 'demo-onboarding';

    #[LiveProp]
    public array $context = [];

    #[LiveProp(writable: true)]
    public array $value = [];

    #[LiveProp(writable: true)]
    public array $fieldError = [];

    #[LiveProp(writable: true)]
    public string $flash = '';

    #[LiveProp(writable: true)]
    public int $stepIndex = 0;

    public function __construct(private readonly InterfaceWizardHandlerRegistryInterface $registry)
    {
    }

    public function __invoke(): void
    {
    }

    public function mount(): void
    {
        if ([] !== $this->value) {
            return;
        }
        $this->value = $this->handler()->initialValue($this->context);
    }

    public function spec(): InterfaceWizardSpec
    {
        return $this->handler()->spec($this->context);
    }

    public function progress(): InterfaceWizardProgress
    {
        $spec = $this->spec();

        return new InterfaceWizardProgress($this->stepIndex, count($spec->step()));
    }

    public function step(): InterfaceWizardStepSpec
    {
        $spec = $this->spec();
        $idx = max(0, min($this->stepIndex, count($spec->step()) - 1));

        return $spec->step()[$idx];
    }

    public function fieldErrorFor(string $id): string
    {
        $msg = $this->fieldError[$id] ?? '';

        return is_string($msg) ? $msg : '';
    }

    #[LiveAction]
    public function next(): void
    {
        $step = $this->step();
        $r = $this->handler()->validateStep($step->id(), $this->value, $this->context);
        $this->fieldError = $r->fieldError();
        $this->value = $r->value();
        $this->flash = '';
        if (!$r->ok()) {
            $this->flash = 'Fix errors before continue.';

            return;
        }
        ++$this->stepIndex;
        $this->fieldError = [];
    }

    #[LiveAction]
    public function back(): void
    {
        $this->flash = '';
        $this->fieldError = [];
        $this->stepIndex = max(0, $this->stepIndex - 1);
    }

    #[LiveAction]
    public function finish(): void
    {
        $step = $this->step();
        $r = $this->handler()->validateStep($step->id(), $this->value, $this->context);
        $this->fieldError = $r->fieldError();
        $this->value = $r->value();
        if (!$r->ok()) {
            $this->flash = 'Fix errors before finish.';

            return;
        }

        $res = $this->handler()->finish($this->value, $this->context);
        $this->fieldError = $res->fieldError();
        $this->value = $res->value();
        $this->flash = $res->message();
    }

    #[LiveAction]
    public function reset(): void
    {
        $this->flash = '';
        $this->fieldError = [];
        $this->stepIndex = 0;
        $this->value = $this->handler()->initialValue($this->context);
    }

    private function handler(): \App\Interfacing\HandlerInterface\Widget\Wizard\InterfaceWizardHandlerInterface
    {
        return $this->registry->get($this->handlerId);
    }
}
