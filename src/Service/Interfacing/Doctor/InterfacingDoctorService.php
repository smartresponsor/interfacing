<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Service\Interfacing\Doctor;

use App\Domain\Interfacing\Doctor\DoctorIssue;
use App\Domain\Interfacing\Doctor\DoctorReport;
use App\DomainInterface\Interfacing\Doctor\DoctorReportInterface;
use App\InfraInterface\Interfacing\Telemetry\InterfacingTelemetryInterface;
use App\ServiceInterface\Interfacing\Action\ActionCatalogInterface;
use App\ServiceInterface\Interfacing\Doctor\InterfacingDoctorServiceInterface;
use App\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\ServiceInterface\Interfacing\Screen\ScreenCatalogInterface;

final class InterfacingDoctorService implements InterfacingDoctorServiceInterface
{
    public function __construct(
        private readonly ScreenCatalogInterface $screenCatalog,
        private readonly LayoutCatalogInterface $layoutCatalog,
        private readonly ActionCatalogInterface $actionCatalog,
        private readonly InterfacingTelemetryInterface $telemetry,
    ) {}

    public function report(): DoctorReportInterface
    {
        $start = microtime(true);

        $screenItem = $this->screenCatalog->all();
        $layoutItem = $this->layoutCatalog->all();
        $actionItem = $this->actionCatalog->all();

        $issueItem = [];

        foreach ($screenItem as $screen) {
            if (!$this->layoutCatalog->has($screen->layoutId())) {
                $issueItem[] = new DoctorIssue(
                    'error',
                    'Screen "' . $screen->id()->value() . '" references missing layout "' . $screen->layoutId()->value() . '".',
                    'missing_layout',
                );
            }
        }

        if (count($screenItem) === 0) { $issueItem[] = new DoctorIssue('warn', 'No screen registered.', 'empty_screen'); }
        if (count($layoutItem) === 0) { $issueItem[] = new DoctorIssue('warn', 'No layout registered.', 'empty_layout'); }
        if (count($actionItem) === 0) { $issueItem[] = new DoctorIssue('warn', 'No action endpoint registered.', 'empty_action'); }

        $ms = (microtime(true) - $start) * 1000.0;
        $this->telemetry->timing('doctor.report', $ms, [
            'screenCount' => count($screenItem),
            'layoutCount' => count($layoutItem),
            'actionCount' => count($actionItem),
        ]);

        return new DoctorReport($screenItem, $layoutItem, $actionItem, $issueItem);
    }
}

