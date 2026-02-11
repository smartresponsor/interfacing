<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\DomainInterface\Interfacing\Model\Action;

    use App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface;

    /**
     *
     */

    /**
     *
     */
    interface ActionRequestInterface
{
    /**
     * @return string
     */
    public function screenId(): string;

    /**
     * @return string
     */
    public function actionId(): string;

    /** @return array<string, mixed> */
    public function payload(): array;

    /**
     * @return \App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface
     */
    public function context(): ScreenContextInterface;

    /** @return array<string, mixed> */
    public function state(): array;
}

