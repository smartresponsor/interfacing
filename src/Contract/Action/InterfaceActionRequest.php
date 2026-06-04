<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Action;

use App\Interfacing\Contract\ValueObject\InterfaceActionId;
use App\Interfacing\Contract\ValueObject\InterfaceScreenId;

final readonly class InterfaceActionRequest
{
    /**
     * @param array<string, mixed> $payload
     * @param array<string, mixed> $context
     */
    public function __construct(
        private InterfaceScreenId $screenId,
        private InterfaceActionId $actionId,
        private array $payload,
        private array $context,
    ) {
    }

    public function screenId(): InterfaceScreenId
    {
        return $this->screenId;
    }

    public function actionId(): InterfaceActionId
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
