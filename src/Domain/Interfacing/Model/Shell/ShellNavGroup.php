<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Shell;

use App\DomainInterface\Interfacing\Model\Shell\ShellNavGroupInterface;

final class ShellNavGroup implements ShellNavGroupInterface
{
    /**
     * @param list<ShellNavItem> $item
     */
    public function __construct(
        private string $id,
        private string $title,
        private array $item,
    ) {
        $this->id = trim($this->id);
        if ($this->id === '') {
            throw new \InvalidArgumentException('ShellNavGroup id must be non-empty.');
        }
    }

    public function id(): string { return $this->id; }
    public function title(): string { return $this->title; }

    /**
     * @return list<ShellNavItem>
     */
    public function item(): array { return $this->item; }
}
