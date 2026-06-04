<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Contract\Doctor;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpecInterface;
use App\Interfacing\Contract\View\InterfaceScreenSpecInterface;
use App\Interfacing\EndpointInterface\Action\InterfaceActionEndpointInterface;
use App\Interfacing\ServiceInterface\Doctor\InterfaceDoctorIssueInterface;
use App\Interfacing\ServiceInterface\Doctor\InterfaceDoctorReportInterface;

final readonly class InterfaceDoctorReport implements InterfaceDoctorReportInterface
{
    /** @param array<int, InterfaceScreenSpecInterface> $screenItem
     * @param array<int, InterfaceLayoutScreenSpecInterface> $layoutItem
     * @param array<int, InterfaceActionEndpointInterface>   $actionItem
     * @param array<int, InterfaceDoctorIssueInterface>      $issueItem
     */
    public function __construct(private array $screenItem, private array $layoutItem, private array $actionItem, private array $issueItem)
    {
    }

    public function screenItem(): array
    {
        return $this->screenItem;
    }

    public function layoutItem(): array
    {
        return $this->layoutItem;
    }

    public function actionItem(): array
    {
        return $this->actionItem;
    }

    public function issueItem(): array
    {
        return $this->issueItem;
    }
}
