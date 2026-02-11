<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\DomainInterface\Interfacing\Doctor;

use App\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use App\DomainInterface\Interfacing\Layout\LayoutSpecInterface;
use App\DomainInterface\Interfacing\Screen\ScreenSpecInterface;

/**
 *
 */

/**
 *
 */
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

