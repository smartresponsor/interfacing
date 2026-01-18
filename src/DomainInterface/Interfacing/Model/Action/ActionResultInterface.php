<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Action;

    interface ActionResultInterface
{
    public function type(): string;

    /** @return array<string, mixed> */
    public function payload(): array;
}

