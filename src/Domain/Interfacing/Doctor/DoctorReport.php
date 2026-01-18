<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Domain\Interfacing\Doctor;

use SmartResponsor\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use SmartResponsor\DomainInterface\Interfacing\Doctor\DoctorIssueInterface;
use SmartResponsor\DomainInterface\Interfacing\Doctor\DoctorReportInterface;
use SmartResponsor\DomainInterface\Interfacing\Layout\LayoutSpecInterface;
use SmartResponsor\DomainInterface\Interfacing\Screen\ScreenSpecInterface;

final class DoctorReport implements DoctorReportInterface
{
    /** @param array<int, ScreenSpecInterface> $screenItem
      * @param array<int, LayoutSpecInterface> $layoutItem
      * @param array<int, ActionEndpointInterface> $actionItem
      * @param array<int, DoctorIssueInterface> $issueItem
      */
    public function __construct(private readonly array $screenItem, private readonly array $layoutItem, private readonly array $actionItem, private readonly array $issueItem) {}

    public function screenItem(): array { return $this->screenItem; }
    public function layoutItem(): array { return $this->layoutItem; }
    public function actionItem(): array { return $this->actionItem; }
    public function issueItem(): array { return $this->issueItem; }
}

