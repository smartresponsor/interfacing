<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Service\Interfacing\Doctor;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\ActionCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\ScreenCatalogInterface;

final class DoctorReport
{
    public function __construct(private ScreenCatalogInterface $screenCatalog, private ActionCatalogInterface $actionCatalog) {}

    /** @return array<string,mixed> */
    public function build(): array
    {
        $screen = [];
        foreach ($this->screenCatalog->all() as $s) {
            $screen[] = ['id' => $s->id()->toString(), 'title' => $s->title(), 'viewId' => $s->viewId()];
        }

        $action = [];
        foreach ($this->actionCatalog->all() as $a) {
            $action[] = ['id' => $a->id()->toString(), 'class' => $a::class];
        }

        return ['screen' => $screen, 'action' => $action];
    }
}
