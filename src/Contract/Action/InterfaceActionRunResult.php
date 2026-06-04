<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Contract\Action;

use App\Interfacing\Contract\Ui\InterfaceUiErrorInterface;

final readonly class InterfaceActionRunResult implements InterfaceActionRunResultInterface
{
    /** @param list<InterfaceUiErrorInterface> $errorItem @param list<\App\Interfacing\Contract\Ui\InterfaceUiMessageInterface> $messageItem */
    public function __construct(
        private InterfaceActionResultInterface $result,
        private array $errorItem,
        private array $messageItem,
    ) {
    }

    public function result(): InterfaceActionResultInterface
    {
        return $this->result;
    }

    /** @return list<InterfaceUiErrorInterface> */
    public function errorItem(): array
    {
        return $this->errorItem;
    }

    /** @return list<\App\Interfacing\Contract\Ui\InterfaceUiMessageInterface> */
    public function messageItem(): array
    {
        return $this->messageItem;
    }
}
