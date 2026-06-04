<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

final class InterfaceShellView implements InterfaceShellViewInterface
{
    /**
     * @param list<InterfaceShellNavGroup> $group
     */
    public function __construct(
        private ?string $activeId,
        private string $query,
        private readonly array $group,
        private int $itemTotal,
    ) {
        $this->query = trim($this->query);
        $this->itemTotal = max(0, $this->itemTotal);
        if (null !== $this->activeId) {
            $this->activeId = '' !== trim($this->activeId) ? trim($this->activeId) : null;
        }
    }

    public function activeId(): ?string
    {
        return $this->activeId;
    }

    public function query(): string
    {
        return $this->query;
    }

    /**
     * @return list<InterfaceShellNavGroup>
     */
    public function group(): array
    {
        return $this->group;
    }

    public function itemTotal(): int
    {
        return $this->itemTotal;
    }
}
