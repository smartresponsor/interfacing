<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Service\Interfacing\Doctor;

use App\ServiceInterface\Interfacing\Doctor\DoctorReportBuilderInterface;
use App\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\ServiceInterface\Interfacing\Screen\ScreenRegistryInterface;

/**
 *
 */

/**
 *
 */
final readonly class DoctorReportBuilder implements DoctorReportBuilderInterface
{
    /**
     * @param \App\ServiceInterface\Interfacing\Screen\ScreenRegistryInterface $screenRegistry
     * @param \App\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface $layoutCatalog
     */
    public function __construct(
        private ScreenRegistryInterface $screenRegistry,
        private LayoutCatalogInterface  $layoutCatalog
    ) {}

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
                'layoutKey' => $spec->layoutKey(),
                'accessCount' => count($spec->accessRule()),
            ];
        }

        $layout = [];
        foreach ($this->layoutCatalog->all() as $key => $spec) {
            $layout[] = [
                'layoutKey' => $key,
                'shellTitle' => $spec->shellTitle(),
                'blockCount' => count($spec->block()),
            ];
        }

        return [
            'screen' => $screen,
            'layout' => $layout,
        ];
    }
}
