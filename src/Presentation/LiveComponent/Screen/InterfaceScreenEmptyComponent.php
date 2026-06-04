<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Screen;

use App\Interfacing\ServiceInterface\LiveComponent\Screen\InterfaceScreenEmptyComponentInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('interfacing_screen_empty', template: 'screen/empty.html.twig')]
final class InterfaceScreenEmptyComponent implements InterfaceScreenEmptyComponentInterface
{
    use DefaultActionTrait;
}
