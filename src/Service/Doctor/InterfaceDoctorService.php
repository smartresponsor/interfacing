<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Doctor;

use App\Interfacing\CatalogInterface\Layout\InterfaceLayoutCatalogInterface;
use App\Interfacing\Contract\Doctor\InterfaceDoctorIssue;
use App\Interfacing\Contract\Doctor\InterfaceDoctorReport;
use App\Interfacing\RegistryInterface\Runtime\InterfaceScreenRegistryInterface;
use App\Interfacing\RegistryInterface\Widget\Form\InterfaceFormHandlerRegistryInterface;
use App\Interfacing\RegistryInterface\Widget\Metric\InterfaceMetricProviderRegistryInterface;
use App\Interfacing\RegistryInterface\Widget\Wizard\InterfaceWizardHandlerRegistryInterface;
use App\Interfacing\ServiceInterface\Doctor\InterfaceDoctorInterface;
use App\Interfacing\ServiceInterface\Doctor\InterfaceDoctorReportInterface;
use App\Interfacing\ServiceInterface\Doctor\InterfaceDoctorServiceInterface;
use Twig\Environment;

final class InterfaceDoctorService implements InterfaceDoctorInterface, InterfaceDoctorServiceInterface
{
    public function __construct(
        private readonly Environment $twig,
        private readonly InterfaceLayoutCatalogInterface $layout,
        private readonly InterfaceScreenRegistryInterface $screen,
        private readonly InterfaceMetricProviderRegistryInterface $metric,
        private readonly InterfaceFormHandlerRegistryInterface $form,
        private readonly InterfaceWizardHandlerRegistryInterface $wizard,
    ) {
    }

    public function check(): array
    {
        $item = [];

        $item[] = $this->checkClass('ux_twig_component', 'Symfony\\UX\\TwigComponent\\Attribute\\AsTwigComponent');

        $item[] = $this->checkTwig('twig_index', 'page/index.html.twig');
        $item[] = $this->checkTwig('twig_screen', 'page/screen.html.twig');

        $item[] = $this->checkRegistryCoherence();

        $item[] = $this->checkMetricProvider();
        $item[] = $this->checkFormHandler();
        $item[] = $this->checkWizardHandler();

        $ok = true;
        foreach ($item as $it) {
            if (!$it['ok']) {
                $ok = false;
                break;
            }
        }

        return ['ok' => $ok, 'item' => $item];
    }

    public function report(): InterfaceDoctorReportInterface
    {
        $check = $this->check();
        $issue = [];

        foreach ($check['item'] as $item) {
            if (true === $item['ok']) {
                continue;
            }

            $issue[] = new InterfaceDoctorIssue('error', $item['message'], $item['code']);
        }

        return new InterfaceDoctorReport(
            [],
            array_values($this->layout->all()),
            [],
            $issue,
        );
    }

    private function checkClass(string $code, string $class): array
    {
        return [
            'code' => $code,
            'ok' => class_exists($class),
            'message' => class_exists($class) ? 'ok' : 'missing class: '.$class,
        ];
    }

    private function checkTwig(string $code, string $name): array
    {
        $exists = $this->twig->getLoader()->exists($name);

        return [
            'code' => $code,
            'ok' => $exists,
            'message' => $exists ? 'ok' : 'missing twig template: '.$name,
        ];
    }

    private function checkRegistryCoherence(): array
    {
        foreach ($this->layout->list() as $spec) {
            if (!$this->screen->has($spec->screenId())) {
                return [
                    'code' => 'screen_registry',
                    'ok' => false,
                    'message' => 'missing screen registry mapping for: '.$spec->screenId()->toString(),
                ];
            }
        }

        return ['code' => 'screen_registry', 'ok' => true, 'message' => 'ok'];
    }

    private function checkMetricProvider(): array
    {
        if (!$this->metric->has('demo')) {
            return ['code' => 'metric_provider', 'ok' => false, 'message' => 'missing metric provider: demo'];
        }

        $list = $this->metric->get('demo')->list();
        if ([] === $list) {
            return ['code' => 'metric_provider', 'ok' => false, 'message' => 'metric provider demo returned empty list'];
        }

        return ['code' => 'metric_provider', 'ok' => true, 'message' => 'ok'];
    }

    private function checkFormHandler(): array
    {
        if (!$this->form->has('demo-profile')) {
            return ['code' => 'form_handler', 'ok' => false, 'message' => 'missing form handler: demo-profile'];
        }

        $h = $this->form->get('demo-profile');
        $spec = $h->spec();
        $val = $h->initialValue();
        $res = $h->submit($val);

        if ([] === $spec->field()) {
            return ['code' => 'form_handler', 'ok' => false, 'message' => 'form spec has no field'];
        }

        if ('' === $res->message()) {
            return ['code' => 'form_handler', 'ok' => false, 'message' => 'form submit returned empty message'];
        }

        return ['code' => 'form_handler', 'ok' => true, 'message' => 'ok'];
    }

    private function checkWizardHandler(): array
    {
        if (!$this->wizard->has('demo-onboarding')) {
            return ['code' => 'wizard_handler', 'ok' => false, 'message' => 'missing wizard handler: demo-onboarding'];
        }

        $h = $this->wizard->get('demo-onboarding');
        $spec = $h->spec();
        if ([] === $spec->step()) {
            return ['code' => 'wizard_handler', 'ok' => false, 'message' => 'wizard spec has no step'];
        }

        $val = $h->initialValue();
        $first = $spec->step()[0];
        $r = $h->validateStep($first->id(), $val);
        if (!$r->ok()) {
            return ['code' => 'wizard_handler', 'ok' => false, 'message' => 'wizard step validation failed on initialValue'];
        }

        return ['code' => 'wizard_handler', 'ok' => true, 'message' => 'ok'];
    }
}
