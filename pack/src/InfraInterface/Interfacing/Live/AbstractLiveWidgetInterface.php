<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\InfraInterface\Interfacing\Live;

use App\DomainInterface\Interfacing\Model\UiStateInterface;

interface AbstractLiveWidgetInterface
{
    public function toUiState(): UiStateInterface;

    public function fromUiState(UiStateInterface $state): void;
}
