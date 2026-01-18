<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\Infra\Interfacing\Live;

use App\Domain\Interfacing\Model\UiState;
use App\DomainInterface\Interfacing\Model\UiStateInterface;
use App\InfraInterface\Interfacing\Live\AbstractLiveWidgetInterface;

abstract class AbstractLiveWidget implements AbstractLiveWidgetInterface
{
    public function toUiState(): UiStateInterface
    {
        return UiState::fromArray([]);
    }

    public function fromUiState(UiStateInterface $state): void
    {
        (void) $state;
    }
}
