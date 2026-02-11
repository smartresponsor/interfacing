<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Infra\Interfacing\Live\Screen;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_screen_wizard_demo', template: 'interfacing/screen/wizard-demo.html.twig')]
final class ScreenWizardDemoComponent
{
    #[LiveProp]
    public array $context = [];
}
