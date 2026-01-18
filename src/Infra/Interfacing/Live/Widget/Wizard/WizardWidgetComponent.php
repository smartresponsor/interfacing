<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Infra\Interfacing\Live\Widget\Wizard;

use App\Domain\Interfacing\Model\Wizard\WizardProgress;
use App\Domain\Interfacing\Model\Wizard\WizardSpec;
use App\Domain\Interfacing\Model\Wizard\WizardStepSpec;
use App\ServiceInterface\Interfacing\Widget\Wizard\WizardHandlerRegistryInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_widget_wizard', template: 'interfacing/widget/wizard/wizard.html.twig')]
final class WizardWidgetComponent
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

    public function __construct(private WizardHandlerRegistryInterface $registry)
    {
    }

    public function mount(): void
    {
        if ($this->value !== []) { return; }
        $this->value = $this->handler()->initialValue($this->context);
    }

    public function spec(): WizardSpec
    {
        return $this->handler()->spec($this->context);
    }

    public function progress(): WizardProgress
    {
        $spec = $this->spec();
        return new WizardProgress($this->stepIndex, count($spec->step()));
    }

    public function step(): WizardStepSpec
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
        $this->stepIndex++;
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

    private function handler()
    {
        return $this->registry->get($this->handlerId);
    }
}
