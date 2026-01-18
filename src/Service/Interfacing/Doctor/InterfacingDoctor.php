<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Service\Interfacing\Doctor;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Doctor\InterfacingDoctorInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\Form\FormHandlerRegistryInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\Metric\MetricProviderRegistryInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\Wizard\WizardHandlerRegistryInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

final class InterfacingDoctor implements InterfacingDoctorInterface
{
    public function __construct(
        private RouterInterface $router,
        private Environment $twig,
        private LayoutCatalogInterface $layout,
        private ScreenRegistryInterface $screen,
        private MetricProviderRegistryInterface $metric,
        private FormHandlerRegistryInterface $form,
        private WizardHandlerRegistryInterface $wizard,
    ) {
    }

    public function check(): array
    {
        $item = [];

        $item[] = $this->checkClass('ux_live_component', 'Symfony\\UX\\LiveComponent\\Attribute\\AsLiveComponent');
        $item[] = $this->checkClass('ux_twig_component', 'Symfony\\UX\\TwigComponent\\Attribute\\AsTwigComponent');

        $item[] = $this->checkRoute('route_index', 'interfacing_index');
        $item[] = $this->checkRoute('route_screen', 'interfacing_screen');

        $item[] = $this->checkTwig('twig_index', 'interfacing/page/index.html.twig');
        $item[] = $this->checkTwig('twig_screen', 'interfacing/page/screen.html.twig');

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

    private function checkClass(string $code, string $class): array
    {
        return [
            'code' => $code,
            'ok' => class_exists($class),
            'message' => class_exists($class) ? 'ok' : 'missing class: '.$class,
        ];
    }

    private function checkRoute(string $code, string $name): array
    {
        $route = $this->router->getRouteCollection()->get($name);

        return [
            'code' => $code,
            'ok' => $route !== null,
            'message' => $route !== null ? 'ok' : 'missing route: '.$name,
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

        $list = $this->metric->get('demo')->list([]);
        if ($list === []) {
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
        $spec = $h->spec([]);
        $val = $h->initialValue([]);
        $res = $h->submit($val, []);

        if ($spec->field() === []) {
            return ['code' => 'form_handler', 'ok' => false, 'message' => 'form spec has no field'];
        }

        if ($res->message() === '') {
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
        $spec = $h->spec([]);
        if ($spec->step() === []) {
            return ['code' => 'wizard_handler', 'ok' => false, 'message' => 'wizard spec has no step'];
        }

        $val = $h->initialValue([]);
        $first = $spec->step()[0];
        $r = $h->validateStep($first->id(), $val, []);
        if (!$r->ok()) {
            return ['code' => 'wizard_handler', 'ok' => false, 'message' => 'wizard step validation failed on initialValue'];
        }

        return ['code' => 'wizard_handler', 'ok' => true, 'message' => 'ok'];
    }
}
