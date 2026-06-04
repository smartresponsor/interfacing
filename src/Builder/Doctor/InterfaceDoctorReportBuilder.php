<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Builder\Doctor;

use App\Interfacing\BuilderInterface\Doctor\InterfaceDoctorReportBuilderInterface;
use App\Interfacing\CatalogInterface\Layout\InterfaceLayoutCatalogInterface;
use App\Interfacing\RegistryInterface\AttributeRegistry\InterfaceScreenRegistryInterface;

final readonly class InterfaceDoctorReportBuilder implements InterfaceDoctorReportBuilderInterface
{
    public function __construct(
        private InterfaceScreenRegistryInterface $screenRegistry,
        private InterfaceLayoutCatalogInterface $layoutCatalog,
    ) {
    }

    /**
     * @return array[]
     */
    public function build(): array
    {
        $screen = [];
        foreach ($this->screenRegistry->all() as $id => $spec) {
            $screen[] = [
                'screenId' => $id,
                'title' => $spec->title(),
                'layoutId' => $spec->layoutId(),
                'accessCount' => count($spec->requireRole()),
            ];
        }

        $layout = [];
        foreach ($this->layoutCatalog->all() as $key => $spec) {
            $layout[] = [
                'layoutId' => $key,
                'shellTitle' => $spec->title(),
                'blockCount' => count($spec->block()),
            ];
        }

        return [
            'screen' => $screen,
            'layout' => $layout,
        ];
    }
}
