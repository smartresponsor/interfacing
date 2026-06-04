<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Action;

use App\Interfacing\Contract\Ui\InterfaceUiErrorInterface;
use App\Interfacing\Contract\Ui\InterfaceUiMessageInterface;

final class InterfaceActionRuntime implements InterfaceActionRuntimeInterface
{
    /** @var array<int, InterfaceUiErrorInterface> */
    private array $errorItem = [];

    /** @var array<int, InterfaceUiMessageInterface> */
    private array $messageItem = [];

    public function addError(InterfaceUiErrorInterface $error): void
    {
        $this->errorItem[] = $error;
    }

    public function addMessage(InterfaceUiMessageInterface $message): void
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
