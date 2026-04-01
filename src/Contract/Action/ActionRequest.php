<?php

declare(strict_types=1);

namespace App\Contract\Action;

use App\Contract\ValueObject\ActionId;
use App\Contract\ValueObject\ScreenId;

final readonly class ActionRequest
{
    /**
     * @param array<string, mixed> $payload
     * @param array<string, mixed> $context
     */
    public function __construct(
        private ScreenId $screenId,
        private ActionId $actionId,
        private array $payload,
        private array $context,
    ) {
    }

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
