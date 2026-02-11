<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\ServiceInterface\Interfacing\Action;

use App\DomainInterface\Interfacing\Action\ActionResultInterface;
use App\DomainInterface\Interfacing\Ui\UiErrorInterface;
use App\DomainInterface\Interfacing\Ui\UiMessageInterface;

interface InterfacingActionRunResultInterface
{
    public function result(): ActionResultInterface;

    /** @return array<int, UiErrorInterface> */
    public function errorItem(): array;

    /** @return array<int, UiMessageInterface> */
    public function messageItem(): array;
}

