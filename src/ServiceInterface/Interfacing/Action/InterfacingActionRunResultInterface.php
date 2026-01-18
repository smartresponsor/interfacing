<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\ServiceInterface\Interfacing\Action;

use SmartResponsor\DomainInterface\Interfacing\Action\ActionResultInterface;
use SmartResponsor\DomainInterface\Interfacing\Ui\UiErrorInterface;
use SmartResponsor\DomainInterface\Interfacing\Ui\UiMessageInterface;

interface InterfacingActionRunResultInterface
{
    public function result(): ActionResultInterface;

    /** @return array<int, UiErrorInterface> */
    public function errorItem(): array;

    /** @return array<int, UiMessageInterface> */
    public function messageItem(): array;
}

