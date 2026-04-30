<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Interfacing\Widget\Form;

use App\Interfacing\Contract\View\FormSpec;
use App\Interfacing\ServiceInterface\Interfacing\Widget\Form\FormHandlerRegistryInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_widget_form', template: 'interfacing/widget/form/form.html.twig')]
final class FormWidgetComponent
{
    #[LiveProp]
    public string $handlerId = 'demo-profile';

    #[LiveProp]
    public array $context = [];

    #[LiveProp(writable: true)]
    public array $value = [];

    #[LiveProp(writable: true)]
    public array $fieldError = [];

    #[LiveProp(writable: true)]
    public string $flash = '';

    public function __construct(private readonly FormHandlerRegistryInterface $registry)
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
        $this->value = $this->registry->get($this->handlerId)->initialValue($this->context);
    }

    public function spec(): FormSpec
    {
        return $this->registry->get($this->handlerId)->spec($this->context);
    }

    public function fieldErrorFor(string $id): string
    {
        $msg = $this->fieldError[$id] ?? '';

        return is_string($msg) ? $msg : '';
    }

    #[LiveAction]
    public function submit(): void
    {
        $h = $this->registry->get($this->handlerId);
        $res = $h->submit($this->value, $this->context);
        $this->flash = $res->message();
        $this->fieldError = $res->fieldError();
        $this->value = $res->value();
    }

    #[LiveAction]
    public function reset(): void
    {
        $this->flash = '';
        $this->fieldError = [];
        $this->value = $this->registry->get($this->handlerId)->initialValue($this->context);
    }
}
