<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Screen;

use App\Interfacing\CatalogInterface\Layout\InterfaceLayoutCatalogInterface;
use App\Interfacing\ServiceInterface\LiveComponent\Screen\InterfaceScreenHomeComponentInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('interfacing_screen_home', template: 'screen/home.html.twig')]
final class InterfaceScreenHomeComponent implements InterfaceScreenHomeComponentInterface
{
    public function __construct(private readonly InterfaceLayoutCatalogInterface $catalog)
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
