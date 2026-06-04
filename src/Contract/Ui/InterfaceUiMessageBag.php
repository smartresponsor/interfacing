<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\Ui;

final class InterfaceUiMessageBag
{
    /** @var InterfaceUiMessage[] */
    private array $item = [];

    public function add(InterfaceUiMessage $message): void
    {
        $this->item[] = $message;
    }

    /** @return InterfaceUiMessage[] */
    public function all(): array
    {
        return $this->item;
    }

    public function hasAny(): bool
    {
        return [] !== $this->item;
    }

    /** @return array<int, array<string, mixed>> */
    public function toArray(): array
    {
        return array_map(static fn (InterfaceUiMessage $m) => $m->toArray(), $this->item);
    }

    /** @param array<int, array<string, mixed>> $data */
    public static function fromArrayList(array $data): self
    {
        $bag = new self();
        foreach ($data as $row) {
            if (is_array($row)) {
                $bag->add(InterfaceUiMessage::fromArray($row));
            }
        }

        return $bag;
    }
}
