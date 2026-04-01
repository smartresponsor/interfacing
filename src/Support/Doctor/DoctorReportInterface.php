<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Support\Doctor;

use App\Contract\View\LayoutScreenSpecInterface;
use App\Contract\View\ScreenSpecInterface;
use App\ServiceInterface\Interfacing\Action\ActionEndpointInterface;

interface DoctorReportInterface
{
    /** @return array<int, ScreenSpecInterface> */
    public function screenItem(): array;

    /** @return array<int, LayoutScreenSpecInterface> */
    public function layoutItem(): array;

    /** @return array<int, ActionEndpointInterface> */
    public function actionItem(): array;

    /** @return array<int, DoctorIssueInterface> */
    public function issueItem(): array;
}
