<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\DomainInterface\Interfacing\Action;

use App\DomainInterface\Interfacing\Ui\UiErrorInterface;
use App\DomainInterface\Interfacing\Ui\UiMessageInterface;

/**
 *
 */

/**
 *
 */
interface ActionRuntimeInterface
{
    /**
     * @param \App\DomainInterface\Interfacing\Ui\UiErrorInterface $error
     * @return void
     */
    public function addError(UiErrorInterface $error): void;

    /**
     * @param \App\DomainInterface\Interfacing\Ui\UiMessageInterface $message
     * @return void
     */
    public function addMessage(UiMessageInterface $message): void;

    /** @return array<int, UiErrorInterface> */
    public function errorItem(): array;

    /** @return array<int, UiMessageInterface> */
    public function messageItem(): array;
}

