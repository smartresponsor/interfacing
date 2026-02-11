<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Domain\Interfacing\Model\Action;

    use App\DomainInterface\Interfacing\Model\Action\ActionRequestInterface;
use App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface;

final class ActionRequest implements ActionRequestInterface
{
    /** @param array<string, mixed> $payload
     *  @param array<string, mixed> $state
     */
    public function __construct(
        private readonly string $screenId,
        private readonly string $actionId,
        private readonly array $payload,
        private readonly array $state,
        private readonly ScreenContextInterface $context,
    ) {}

    public function screenId(): string
    {
        return $this->screenId;
    }

    public function actionId(): string
    {
        return $this->actionId;
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function context(): ScreenContextInterface
    {
        return $this->context;
    }

    public function state(): array
    {
        return $this->state;
    }
}

