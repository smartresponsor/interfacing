<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Domain\Interfacing\Model\Action;

    use App\DomainInterface\Interfacing\Model\Action\ActionRequestInterface;
use App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface;

    /**
     *
     */

    /**
     *
     */
    final readonly class ActionRequest implements ActionRequestInterface
{
    /** @param array<string, mixed> $payload
     *  @param array<string, mixed> $state
     */
    public function __construct(
        private string                 $screenId,
        private string                 $actionId,
        private array                  $payload,
        private array                  $state,
        private ScreenContextInterface $context,
    ) {}

    /**
     * @return string
     */
    public function screenId(): string
    {
        return $this->screenId;
    }

    /**
     * @return string
     */
    public function actionId(): string
    {
        return $this->actionId;
    }

    /**
     * @return mixed[]
     */
    public function payload(): array
    {
        return $this->payload;
    }

    /**
     * @return \App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface
     */
    public function context(): ScreenContextInterface
    {
        return $this->context;
    }

    /**
     * @return mixed[]
     */
    public function state(): array
    {
        return $this->state;
    }
}

