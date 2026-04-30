<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Action;

use App\Interfacing\Contract\Ui\UiErrorInterface;
use App\Interfacing\Contract\Ui\UiMessageInterface;

interface ActionRuntimeInterface
{
    public function addError(UiErrorInterface $error): void;

    public function addMessage(UiMessageInterface $message): void;

    /** @return array<int, UiErrorInterface> */
    public function errorItem(): array;

    /** @return array<int, UiMessageInterface> */
    public function messageItem(): array;
}
