<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing\Action;

use App\Contract\Action\ActionResultInterface;
use App\Contract\Ui\UiErrorInterface;
use App\ServiceInterface\Interfacing\Action\InterfacingActionRunResultInterface;

final readonly class InterfacingActionRunResult implements InterfacingActionRunResultInterface
{
    /** @param list<UiErrorInterface> $errorItem @param list<\App\Contract\Ui\UiMessageInterface> $messageItem */
    public function __construct(
        private ActionResultInterface $result,
        private array $errorItem,
        private array $messageItem,
    ) {
    }

    public function result(): ActionResultInterface
    {
        return $this->result;
    }

    /** @return list<UiErrorInterface> */
    public function errorItem(): array
    {
        return $this->errorItem;
    }

    /** @return list<\App\Contract\Ui\UiMessageInterface> */
    public function messageItem(): array
    {
        return $this->messageItem;
    }
}
