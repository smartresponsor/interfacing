<?php

declare(strict_types=1);

namespace App\Contract\Action;

use App\Contract\Ui\UiErrorInterface;
use App\Contract\Ui\UiMessageInterface;

interface ActionRuntimeInterface
{
    public function addError(UiErrorInterface $error): void;

    public function addMessage(UiMessageInterface $message): void;

    /** @return array<int, UiErrorInterface> */
    public function errorItem(): array;

    /** @return array<int, UiMessageInterface> */
    public function messageItem(): array;
}
