<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Presentation\LiveComponent\Interfacing\Screen;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('interfacing_screen_form_demo', template: 'interfacing/screen/form-demo.html.twig')]
final class ScreenFormDemoComponent
{
    use DefaultActionTrait;

    #[LiveProp]
    public array $context = [];
}
