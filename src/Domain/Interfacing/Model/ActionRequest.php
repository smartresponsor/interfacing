<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Model;

use App\Domain\Interfacing\Value\ActionId;
use App\Domain\Interfacing\Value\ScreenId;

final class ActionRequest
{
    /** @param array<string,mixed> $payload @param array<string,mixed> $context */
    public function __construct(
        private ScreenId $screenId,
        private ActionId $actionId,
        private array $payload,
        private array $context
    ) {}

    public function screenId(): ScreenId { return $this->screenId; }
    public function actionId(): ActionId { return $this->actionId; }
    /** @return array<string,mixed> */
    public function payload(): array { return $this->payload; }
    /** @return array<string,mixed> */
    public function context(): array { return $this->context; }
}
