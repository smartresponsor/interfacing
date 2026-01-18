<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Domain\Interfacing\Action;

use SmartResponsor\DomainInterface\Interfacing\Action\ActionRuntimeInterface;
use SmartResponsor\DomainInterface\Interfacing\Ui\UiErrorInterface;
use SmartResponsor\DomainInterface\Interfacing\Ui\UiMessageInterface;

final class ActionRuntime implements ActionRuntimeInterface
{
    /** @var array<int, UiErrorInterface> */
    private array $errorItem = [];
    /** @var array<int, UiMessageInterface> */
    private array $messageItem = [];

    public function addError(UiErrorInterface $error): void { $this->errorItem[] = $error; }
    public function addMessage(UiMessageInterface $message): void { $this->messageItem[] = $message; }

    public function errorItem(): array { return $this->errorItem; }
    public function messageItem(): array { return $this->messageItem; }
}

