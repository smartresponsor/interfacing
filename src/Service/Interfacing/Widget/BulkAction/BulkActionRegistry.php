<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Interfacing\Widget\BulkAction;

use App\Interfacing\Contract\View\BulkActionSpec;
use App\Interfacing\ServiceInterface\Interfacing\Widget\BulkAction\BulkActionHandlerInterface;
use App\Interfacing\ServiceInterface\Interfacing\Widget\BulkAction\BulkActionRegistryInterface;

final class BulkActionRegistry implements BulkActionRegistryInterface
{
    /**
     * @var array<string,BulkActionHandlerInterface>
     */
    private array $handler = [];

    /**
     * @param iterable<BulkActionHandlerInterface> $handler
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
                $out[] = new BulkActionSpec($id, 'Delete', true);
                continue;
            }
            if ('demo-mark-done' === $id) {
                $out[] = new BulkActionSpec($id, 'Mark done', false);
                continue;
            }
            $out[] = new BulkActionSpec($id, $id, true);
        }

        usort($out, static fn (BulkActionSpec $a, BulkActionSpec $b): int => strcmp($a->title(), $b->title()));

        return $out;
    }

    public function has(string $id): bool
    {
        return isset($this->handler[$id]);
    }

    public function handler(string $id): BulkActionHandlerInterface
    {
        if (!isset($this->handler[$id])) {
            throw new \InvalidArgumentException('Unknown bulk action: '.$id);
        }

        return $this->handler[$id];
    }
}
