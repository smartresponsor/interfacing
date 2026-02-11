<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\BulkAction;

/**
 *
 */

/**
 *
 */
final class BulkActionSpec
{
    /**
     * @param string $id
     * @param string $title
     * @param bool $confirm
     */
    public function __construct(
        private string          $id,
        private readonly string $title,
        private readonly bool   $confirm = true,
    ) {
        $this->id = trim($this->id);
        if ($this->id === '') {
            throw new \InvalidArgumentException('BulkAction id must be non-empty.');
        }
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function confirm(): bool
    {
        return $this->confirm;
    }
}
