<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\InfraInterface\Interfacing\Live;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\UiStateInterface;

/**
 *
 */

/**
 *
 */
interface AbstractLiveWidgetInterface
{
    /**
     * @return \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\UiStateInterface
     */
    public function toUiState(): UiStateInterface;

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\UiStateInterface $state
     * @return void
     */
    public function fromUiState(UiStateInterface $state): void;
}
