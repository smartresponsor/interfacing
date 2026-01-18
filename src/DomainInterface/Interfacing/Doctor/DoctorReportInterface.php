<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Doctor;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Layout\LayoutSpecInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Screen\ScreenSpecInterface;

interface DoctorReportInterface
{
    /** @return array<int, ScreenSpecInterface> */
    public function screenItem(): array;

    /** @return array<int, LayoutSpecInterface> */
    public function layoutItem(): array;

    /** @return array<int, ActionEndpointInterface> */
    public function actionItem(): array;

    /** @return array<int, DoctorIssueInterface> */
    public function issueItem(): array;
}

