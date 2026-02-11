<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Domain\Interfacing\Model\Context;

    use App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface;

final class ScreenContext implements ScreenContextInterface
{
    /** @param array<string, mixed> $extra */
    public function __construct(
        private readonly ?string $tenantId,
        private readonly ?string $userId,
        private readonly ?string $locale,
        private readonly array $extra = [],
    ) {}

    public function tenantId(): ?string
    {
        return $this->tenantId;
    }

    public function userId(): ?string
    {
        return $this->userId;
    }

    public function locale(): ?string
    {
        return $this->locale;
    }

    public function extra(): array
    {
        return $this->extra;
    }
}

