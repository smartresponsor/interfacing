<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Doctor;

use App\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportBuilderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Screen\ScreenRegistryInterface;

final readonly class DoctorReportBuilder implements DoctorReportBuilderInterface
{
    public function __construct(
        private ScreenRegistryInterface $screenRegistry,
        private LayoutCatalogInterface $layoutCatalog,
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
