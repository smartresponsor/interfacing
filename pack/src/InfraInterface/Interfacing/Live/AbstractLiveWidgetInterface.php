<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\InfraInterface\Interfacing\Live;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\UiStateInterface;

interface AbstractLiveWidgetInterface
{
    public function toUiState(): UiStateInterface;

    public function fromUiState(UiStateInterface $state): void;
}
