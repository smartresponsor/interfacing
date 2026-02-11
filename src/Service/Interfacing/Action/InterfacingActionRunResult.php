<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Service\Interfacing\Action;

use App\DomainInterface\Interfacing\Action\ActionResultInterface;
use App\DomainInterface\Interfacing\Ui\UiErrorInterface;
use App\DomainInterface\Interfacing\Ui\UiMessageInterface;
use App\ServiceInterface\Interfacing\Action\InterfacingActionRunResultInterface;

/**
 *
 */

/**
 *
 */
final readonly class InterfacingActionRunResult implements InterfacingActionRunResultInterface
{
    /** @param array<int, UiErrorInterface> $errorItem @param array<int, UiMessageInterface> $messageItem */
    public function __construct(
        private ActionResultInterface $result,
        private array                 $errorItem,
        private array                 $messageItem,
    ) {}

    /**
     * @return \App\DomainInterface\Interfacing\Action\ActionResultInterface
     */
    public function result(): ActionResultInterface { return $this->result; }

    /**
     * @return \App\DomainInterface\Interfacing\Ui\UiErrorInterface[]
     */
    public function errorItem(): array { return $this->errorItem; }

    /**
     * @return array|\App\DomainInterface\Interfacing\Ui\UiMessageInterface[]
     */
    public function messageItem(): array { return $this->messageItem; }
}

