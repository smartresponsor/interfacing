<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Action;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Ui\UiErrorInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Ui\UiMessageInterface;

interface ActionRuntimeInterface
{
    public function addError(UiErrorInterface $error): void;
    public function addMessage(UiMessageInterface $message): void;

    /** @return array<int, UiErrorInterface> */
    public function errorItem(): array;

    /** @return array<int, UiMessageInterface> */
    public function messageItem(): array;
}

