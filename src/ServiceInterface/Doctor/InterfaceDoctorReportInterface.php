<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\ServiceInterface\Doctor;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpecInterface;
use App\Interfacing\Contract\View\InterfaceScreenSpecInterface;
use App\Interfacing\EndpointInterface\Action\InterfaceActionEndpointInterface;

interface InterfaceDoctorReportInterface
{
    /** @return array<int, InterfaceScreenSpecInterface> */
    public function screenItem(): array;

    /** @return array<int, InterfaceLayoutScreenSpecInterface> */
    public function layoutItem(): array;

    /** @return array<int, InterfaceActionEndpointInterface> */
    public function actionItem(): array;

    /** @return array<int, InterfaceDoctorIssueInterface> */
    public function issueItem(): array;
}
