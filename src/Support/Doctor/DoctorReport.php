<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Support\Doctor;

use App\Interfacing\Contract\View\LayoutScreenSpecInterface;
use App\Interfacing\Contract\View\ScreenSpecInterface;
use App\Interfacing\ServiceInterface\Interfacing\Action\ActionEndpointInterface;

final readonly class DoctorReport implements DoctorReportInterface
{
    /** @param array<int, ScreenSpecInterface> $screenItem
     * @param array<int, LayoutScreenSpecInterface> $layoutItem
     * @param array<int, ActionEndpointInterface>   $actionItem
     * @param array<int, DoctorIssueInterface>      $issueItem
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
