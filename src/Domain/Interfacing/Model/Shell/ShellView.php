<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Shell;

use App\DomainInterface\Interfacing\Model\Shell\ShellViewInterface;

final class ShellView implements ShellViewInterface
{
    /**
     * @param list<ShellNavGroup> $group
     */
    public function __construct(
        private ?string $activeId,
        private string $query,
        private array $group,
        private int $itemTotal,
    ) {
        $this->query = trim($this->query);
        $this->itemTotal = max(0, $this->itemTotal);
        if ($this->activeId !== null) {
            $this->activeId = trim($this->activeId) !== '' ? trim($this->activeId) : null;
        }
    }

    public function activeId(): ?string { return $this->activeId; }
    public function query(): string { return $this->query; }

    /**
     * @return list<ShellNavGroup>
     */
    public function group(): array { return $this->group; }

    public function itemTotal(): int { return $this->itemTotal; }
}
