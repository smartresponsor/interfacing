<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Context;

    interface ScreenContextInterface
{
    public function tenantId(): ?string;

    public function userId(): ?string;

    public function locale(): ?string;

    /** @return array<string, mixed> */
    public function extra(): array;
}

