<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Action;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Context\ScreenContextInterface;

interface ActionRequestInterface
{
    public function screenId(): string;

    public function actionId(): string;

    /** @return array<string, mixed> */
    public function payload(): array;

    public function context(): ScreenContextInterface;

    /** @return array<string, mixed> */
    public function state(): array;
}

