<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Infra\Interfacing\Live\Screen;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('interfacing_screen_empty', template: 'interfacing/screen/empty.html.twig')]
final class ScreenEmptyComponent implements ScreenEmptyComponentInterface
{
}
