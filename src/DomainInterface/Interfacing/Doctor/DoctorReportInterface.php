<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\DomainInterface\Interfacing\Doctor;

use SmartResponsor\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use SmartResponsor\DomainInterface\Interfacing\Layout\LayoutSpecInterface;
use SmartResponsor\DomainInterface\Interfacing\Screen\ScreenSpecInterface;

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

