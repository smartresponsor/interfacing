<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Interfacing\Screen;

use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('interfacing_screen_home', template: 'interfacing/screen/home.html.twig')]
final class ScreenHomeComponent implements ScreenHomeComponentInterface
{
    public function __construct(private readonly LayoutCatalogInterface $catalog)
    {
    }

    public function __invoke(): void
    {
    }

    /**
     * @return array<array{slug:string,title:string}>
     */
    public function link(): array
    {
        $out = [];
        foreach ($this->catalog->list() as $spec) {
            $out[] = ['slug' => $spec->slug(), 'title' => $spec->title()];
        }

        return $out;
    }
}
