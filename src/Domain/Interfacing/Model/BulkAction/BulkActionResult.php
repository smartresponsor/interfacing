<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Domain\Interfacing\Model\BulkAction;

final class BulkActionResult
{
    /**
     * @param list<string> $removedId
     * @param list<string> $updatedId
     */
    public function __construct(
        private string $message,
        private array $removedId = [],
        private array $updatedId = [],
    ) {
    }

    public function message(): string
    {
        return $this->message;
    }

    /**
     * @return list<string>
     */
    public function removedId(): array
    {
        return $this->removedId;
    }

    /**
     * @return list<string>
     */
    public function updatedId(): array
    {
        return $this->updatedId;
    }
}
