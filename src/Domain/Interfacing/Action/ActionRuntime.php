<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Domain\Interfacing\Action;

use App\DomainInterface\Interfacing\Action\ActionRuntimeInterface;
use App\DomainInterface\Interfacing\Ui\UiErrorInterface;
use App\DomainInterface\Interfacing\Ui\UiMessageInterface;

/**
 *
 */

/**
 *
 */
final class ActionRuntime implements ActionRuntimeInterface
{
    /** @var array<int, UiErrorInterface> */
    private array $errorItem = [];
    /** @var array<int, UiMessageInterface> */
    private array $messageItem = [];

    /**
     * @param \App\DomainInterface\Interfacing\Ui\UiErrorInterface $error
     * @return void
     */
    public function addError(UiErrorInterface $error): void { $this->errorItem[] = $error; }

    /**
     * @param \App\DomainInterface\Interfacing\Ui\UiMessageInterface $message
     * @return void
     */
    public function addMessage(UiMessageInterface $message): void { $this->messageItem[] = $message; }

    /**
     * @return \App\DomainInterface\Interfacing\Ui\UiErrorInterface[]
     */
    public function errorItem(): array { return $this->errorItem; }

    /**
     * @return \App\DomainInterface\Interfacing\Ui\UiMessageInterface[]
     */
    public function messageItem(): array { return $this->messageItem; }
}

