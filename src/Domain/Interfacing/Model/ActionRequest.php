<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Model;

use App\Domain\Interfacing\Value\ActionId;
use App\Domain\Interfacing\Value\ScreenId;

/**
 *
 */

/**
 *
 */
final class ActionRequest
{
    /** @param array<string,mixed> $payload @param array<string,mixed> $context */
    public function __construct(
        private readonly ScreenId $screenId,
        private readonly ActionId $actionId,
        private readonly array    $payload,
        private readonly array    $context
    ) {}

    /**
     * @return \App\Domain\Interfacing\Value\ScreenId
     */
    public function screenId(): ScreenId { return $this->screenId; }

    /**
     * @return \App\Domain\Interfacing\Value\ActionId
     */
    public function actionId(): ActionId { return $this->actionId; }
    /** @return array<string,mixed> */
    public function payload(): array { return $this->payload; }
    /** @return array<string,mixed> */
    public function context(): array { return $this->context; }
}
