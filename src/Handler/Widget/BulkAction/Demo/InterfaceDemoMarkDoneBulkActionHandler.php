<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Handler\Widget\BulkAction\Demo;

use App\Interfacing\Contract\Dto\InterfaceBulkActionResult;
use App\Interfacing\HandlerInterface\Widget\BulkAction\InterfaceBulkActionHandlerInterface;

final class InterfaceDemoMarkDoneBulkActionHandler implements InterfaceBulkActionHandlerInterface
{
    public function id(): string
    {
        return 'demo-mark-done';
    }

    public function execute(array $id, array $context = []): InterfaceBulkActionResult
    {
        $id = array_values(array_unique(array_filter($id, static fn ($x): bool => is_string($x) && '' !== $x)));
        $count = count($id);

        return new InterfaceBulkActionResult('Marked done '.$count.' item(s).', removedId: [], updatedId: $id);
    }
}
