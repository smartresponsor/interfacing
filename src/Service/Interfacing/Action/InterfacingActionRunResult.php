<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Service\Interfacing\Action;

use SmartResponsor\DomainInterface\Interfacing\Action\ActionResultInterface;
use SmartResponsor\DomainInterface\Interfacing\Ui\UiErrorInterface;
use SmartResponsor\DomainInterface\Interfacing\Ui\UiMessageInterface;
use SmartResponsor\ServiceInterface\Interfacing\Action\InterfacingActionRunResultInterface;

final class InterfacingActionRunResult implements InterfacingActionRunResultInterface
{
    /** @param array<int, UiErrorInterface> $errorItem @param array<int, UiMessageInterface> $messageItem */
    public function __construct(
        private readonly ActionResultInterface $result,
        private readonly array $errorItem,
        private readonly array $messageItem,
    ) {}

    public function result(): ActionResultInterface { return $this->result; }
    public function errorItem(): array { return $this->errorItem; }
    public function messageItem(): array { return $this->messageItem; }
}

