<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout;

    interface LayoutBlockSpecInterface
{
    public function type(): string;

    public function key(): string;

    /** @return array<string, mixed> */
    public function props(): array;
}

