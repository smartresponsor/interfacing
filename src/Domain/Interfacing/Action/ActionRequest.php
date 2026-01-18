<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace SmartResponsor\Interfacing\Domain\Interfacing\Action;

use SmartResponsor\Interfacing\Domain\Interfacing\Screen\ScreenId;

final class ActionRequest
{
    /**
     * @param array<string, mixed> $payload
     * @param array<string, mixed> $context
     */
    public function __construct(
        private readonly ScreenId $screenId,
        private readonly ActionId $actionId,
        private readonly array $payload,
        private readonly array $context
    ) {}

    public function screenId(): ScreenId
    {
        return $this->screenId;
    }

    public function actionId(): ActionId
    {
        return $this->actionId;
    }

    /** @return array<string, mixed> */
    public function payload(): array
    {
        return $this->payload;
    }

    /** @return array<string, mixed> */
    public function context(): array
    {
        return $this->context;
    }
}
