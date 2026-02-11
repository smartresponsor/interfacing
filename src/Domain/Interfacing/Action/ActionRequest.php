<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Domain\Interfacing\Action;

use App\Domain\Interfacing\Screen\ScreenId;

/**
 *
 */

/**
 *
 */
final readonly class ActionRequest
{
    /**
     * @param array<string, mixed> $payload
     * @param array<string, mixed> $context
     */
    public function __construct(
        private ScreenId $screenId,
        private ActionId $actionId,
        private array    $payload,
        private array    $context
    ) {}

    /**
     * @return \App\Domain\Interfacing\Screen\ScreenId
     */
    public function screenId(): ScreenId
    {
        return $this->screenId;
    }

    /**
     * @return \App\Domain\Interfacing\Action\ActionId
     */
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
