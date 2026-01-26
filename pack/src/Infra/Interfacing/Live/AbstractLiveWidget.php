<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Infra\Interfacing\Live;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\UiState;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\UiStateInterface;
use SmartResponsor\Interfacing\InfraInterface\Interfacing\Live\AbstractLiveWidgetInterface;

/**
 *
 */
abstract class AbstractLiveWidget implements AbstractLiveWidgetInterface
{
    public function toUiState(): UiStateInterface
    {
        return UiState::fromArray([]);
    }

    public function fromUiState(UiStateInterface $state): void
    {
    }
}
