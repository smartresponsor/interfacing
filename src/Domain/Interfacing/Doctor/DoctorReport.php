<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Domain\Interfacing\Doctor;

use App\DomainInterface\Interfacing\Action\ActionEndpointInterface;
use App\DomainInterface\Interfacing\Doctor\DoctorIssueInterface;
use App\DomainInterface\Interfacing\Doctor\DoctorReportInterface;
use App\DomainInterface\Interfacing\Layout\LayoutSpecInterface;
use App\DomainInterface\Interfacing\Screen\ScreenSpecInterface;

/**
 *
 */

/**
 *
 */
final readonly class DoctorReport implements DoctorReportInterface
{
    /** @param array<int, ScreenSpecInterface> $screenItem
      * @param array<int, LayoutSpecInterface> $layoutItem
      * @param array<int, ActionEndpointInterface> $actionItem
      * @param array<int, DoctorIssueInterface> $issueItem
      */
    public function __construct(private array $screenItem, private array $layoutItem, private array $actionItem, private array $issueItem) {}

    /**
     * @return \App\DomainInterface\Interfacing\Screen\ScreenSpecInterface[]
     */
    public function screenItem(): array { return $this->screenItem; }

    /**
     * @return \App\DomainInterface\Interfacing\Layout\LayoutSpecInterface[]
     */
    public function layoutItem(): array { return $this->layoutItem; }

    /**
     * @return \App\DomainInterface\Interfacing\Action\ActionEndpointInterface[]
     */
    public function actionItem(): array { return $this->actionItem; }

    /**
     * @return \App\DomainInterface\Interfacing\Doctor\DoctorIssueInterface[]
     */
    public function issueItem(): array { return $this->issueItem; }
}

