<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Doctor;

use App\Interfacing\ServiceInterface\Interfacing\Doctor\InterfacingDoctorServiceInterface;
use App\Interfacing\ServiceInterface\Interfacing\Registry\ActionCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\ScreenCatalogInterface;
use App\Interfacing\ServiceInterface\Support\Telemetry\InterfacingTelemetryInterface;
use App\Interfacing\Support\Doctor\DoctorIssue;
use App\Interfacing\Support\Doctor\DoctorReport;
use App\Interfacing\Support\Doctor\DoctorReportInterface;

final readonly class InterfacingDoctorService implements InterfacingDoctorServiceInterface
{
    public function __construct(
        private ScreenCatalogInterface $screenCatalog,
        private LayoutCatalogInterface $layoutCatalog,
        private ActionCatalogInterface $actionCatalog,
        private InterfacingTelemetryInterface $telemetry,
    ) {
    }

    public function report(): DoctorReportInterface
    {
        $start = microtime(true);

        $screenItem = $this->screenCatalog->all();
        $layoutItem = $this->layoutCatalog->all();
        $actionItem = [];
        foreach ($screenItem as $screen) {
            foreach ($this->actionCatalog->allForScreen($screen->id()) as $action) {
                $actionItem[] = $action;
            }
        }

        $issueItem = [];

        if (0 === count($screenItem)) {
            $issueItem[] = new DoctorIssue('warn', 'No screen registered.', 'empty_screen');
        }
        if (0 === count($layoutItem)) {
            $issueItem[] = new DoctorIssue('warn', 'No layout registered.', 'empty_layout');
        }
        if (0 === count($actionItem)) {
            $issueItem[] = new DoctorIssue('warn', 'No action endpoint registered.', 'empty_action');
        }

        $ms = (microtime(true) - $start) * 1000.0;
        $this->telemetry->timing('doctor.report', $ms, [
            'screenCount' => count($screenItem),
            'layoutCount' => count($layoutItem),
            'actionCount' => count($actionItem),
        ]);

        return new DoctorReport($screenItem, $layoutItem, $actionItem, $issueItem);
    }
}
