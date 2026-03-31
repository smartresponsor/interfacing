<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Doctor;

use App\ServiceInterface\Interfacing\ActionCatalogInterface;
use App\ServiceInterface\Interfacing\ScreenCatalogInterface;

final class DoctorReport
{
    public function __construct(private readonly ScreenCatalogInterface $screenCatalog, private readonly ActionCatalogInterface $actionCatalog)
    {
    }

    /** @return array<string,mixed> */
    public function build(): array
    {
        $screen = [];
        foreach ($this->screenCatalog->all() as $s) {
            $screen[] = ['id' => $s->id(), 'title' => $s->title(), 'viewId' => $s->viewId()];
        }

        $action = [];
        foreach ($this->actionCatalog->all() as $a) {
            $action[] = ['id' => $a->id()->toString(), 'class' => $a::class];
        }

        return ['screen' => $screen, 'action' => $action];
    }
}
