<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Doctor;

use App\Interfacing\CatalogInterface\InterfaceActionEndpointCatalogInterface;
use App\Interfacing\CatalogInterface\InterfaceScreenSpecCatalogInterface;

final class InterfaceDoctorReportService
{
    public function __construct(private readonly InterfaceScreenSpecCatalogInterface $screenCatalog, private readonly InterfaceActionEndpointCatalogInterface $actionCatalog)
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
