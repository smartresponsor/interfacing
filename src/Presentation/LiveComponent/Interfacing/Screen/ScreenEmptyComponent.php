<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Presentation\LiveComponent\Interfacing\Screen;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('interfacing_screen_empty', template: 'interfacing/screen/empty.html.twig')]
final class ScreenEmptyComponent implements ScreenEmptyComponentInterface
{
    use DefaultActionTrait;
}
