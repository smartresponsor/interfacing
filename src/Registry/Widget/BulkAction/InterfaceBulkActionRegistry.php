<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Registry\Widget\BulkAction;

use App\Interfacing\Contract\View\InterfaceBulkActionSpec;
use App\Interfacing\HandlerInterface\Widget\BulkAction\InterfaceBulkActionHandlerInterface;
use App\Interfacing\RegistryInterface\Widget\BulkAction\InterfaceBulkActionRegistryInterface;

final class InterfaceBulkActionRegistry implements InterfaceBulkActionRegistryInterface
{
    /**
     * @var array<string,InterfaceBulkActionHandlerInterface>
     */
    private array $handler = [];

    /**
     * @param iterable<InterfaceBulkActionHandlerInterface> $handler
     */
    public function __construct(iterable $handler)
    {
        foreach ($handler as $h) {
            $this->handler[$h->id()] = $h;
        }
    }

    public function list(): array
    {
        $out = [];
        foreach ($this->handler as $id => $h) {
            if ('demo-delete' === $id) {
                $out[] = new InterfaceBulkActionSpec($id, 'Delete', true);
                continue;
            }
            if ('demo-mark-done' === $id) {
                $out[] = new InterfaceBulkActionSpec($id, 'Mark done', false);
                continue;
            }
            $out[] = new InterfaceBulkActionSpec($id, $id, true);
        }

        usort($out, static fn (InterfaceBulkActionSpec $a, InterfaceBulkActionSpec $b): int => strcmp($a->title(), $b->title()));

        return $out;
    }

    public function has(string $id): bool
    {
        return isset($this->handler[$id]);
    }

    public function handler(string $id): InterfaceBulkActionHandlerInterface
    {
        if (!isset($this->handler[$id])) {
            throw new \InvalidArgumentException('Unknown bulk action: '.$id);
        }

        return $this->handler[$id];
    }
}
