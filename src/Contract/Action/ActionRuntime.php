<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Action;

use App\Interfacing\Contract\Ui\UiErrorInterface;
use App\Interfacing\Contract\Ui\UiMessageInterface;

final class ActionRuntime implements ActionRuntimeInterface
{
    /** @var array<int, UiErrorInterface> */
    private array $errorItem = [];

    /** @var array<int, UiMessageInterface> */
    private array $messageItem = [];

    public function addError(UiErrorInterface $error): void
    {
        $this->errorItem[] = $error;
    }

    public function addMessage(UiMessageInterface $message): void
    {
        $this->messageItem[] = $message;
    }

    public function errorItem(): array
    {
        return $this->errorItem;
    }

    public function messageItem(): array
    {
        return $this->messageItem;
    }
}
