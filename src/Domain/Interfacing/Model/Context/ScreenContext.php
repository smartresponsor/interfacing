<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Domain\Interfacing\Model\Context;

    use App\DomainInterface\Interfacing\Model\Context\ScreenContextInterface;

    /**
     *
     */

    /**
     *
     */
    final readonly class ScreenContext implements ScreenContextInterface
{
    /** @param array<string, mixed> $extra */
    public function __construct(
        private ?string $tenantId,
        private ?string $userId,
        private ?string $locale,
        private array   $extra = [],
    ) {}

    /**
     * @return string|null
     */
    public function tenantId(): ?string
    {
        return $this->tenantId;
    }

    /**
     * @return string|null
     */
    public function userId(): ?string
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function locale(): ?string
    {
        return $this->locale;
    }

    /**
     * @return mixed[]
     */
    public function extra(): array
    {
        return $this->extra;
    }
}

