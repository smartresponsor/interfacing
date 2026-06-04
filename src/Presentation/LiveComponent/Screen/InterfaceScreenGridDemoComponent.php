<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Screen;

use App\Interfacing\ServiceInterface\LiveComponent\Screen\InterfaceScreenGridDemoComponentInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('interfacing_screen_grid_demo', template: 'screen/grid-demo.html.twig')]
final class InterfaceScreenGridDemoComponent implements InterfaceScreenGridDemoComponentInterface
{
    use DefaultActionTrait;

    #[LiveProp]
    public array $context = [];
}
