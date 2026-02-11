<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Infra\Interfacing\Live\Widget\Form;

use App\Domain\Interfacing\Model\Form\FormSpec;
use App\ServiceInterface\Interfacing\Widget\Form\FormHandlerRegistryInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

/**
 *
 */

/**
 *
 */
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

    /**
     * @param \App\ServiceInterface\Interfacing\Widget\Form\FormHandlerRegistryInterface $registry
     */
    public function __construct(private readonly FormHandlerRegistryInterface $registry)
    {
    }

    /**
     * @return void
     */
    public function mount(): void
    {
        if ($this->value !== []) { return; }
        $this->value = $this->registry->get($this->handlerId)->initialValue($this->context);
    }

    /**
     * @return \App\Domain\Interfacing\Model\Form\FormSpec
     */
    public function spec(): FormSpec
    {
        return $this->registry->get($this->handlerId)->spec($this->context);
    }

    /**
     * @param string $id
     * @return string
     */
    public function fieldErrorFor(string $id): string
    {
        $msg = $this->fieldError[$id] ?? '';
        return is_string($msg) ? $msg : '';
    }

    /**
     * @return void
     */
    #[LiveAction]
    public function submit(): void
    {
        $h = $this->registry->get($this->handlerId);
        $res = $h->submit($this->value, $this->context);
        $this->flash = $res->message();
        $this->fieldError = $res->fieldError();
        $this->value = $res->value();
    }

    /**
     * @return void
     */
    #[LiveAction]
    public function reset(): void
    {
        $this->flash = '';
        $this->fieldError = [];
        $this->value = $this->registry->get($this->handlerId)->initialValue($this->context);
    }
}
