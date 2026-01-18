<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Service\Interfacing\Doctor;

use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportBuilderInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Screen\ScreenRegistryInterface;

final class DoctorReportBuilder implements DoctorReportBuilderInterface
{
    public function __construct(
        private readonly ScreenRegistryInterface $screenRegistry,
        private readonly LayoutCatalogInterface $layoutCatalog
    ) {}

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
