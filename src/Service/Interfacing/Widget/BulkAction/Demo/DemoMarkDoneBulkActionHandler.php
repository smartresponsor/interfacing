<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Widget\BulkAction\Demo;

use App\Domain\Interfacing\Model\BulkAction\BulkActionResult;
use App\ServiceInterface\Interfacing\Widget\BulkAction\BulkActionHandlerInterface;

final class DemoMarkDoneBulkActionHandler implements BulkActionHandlerInterface
{
    public function id(): string
    {
        return 'demo-mark-done';
    }

    public function execute(array $id, array $context = []): BulkActionResult
    {
        $id = array_values(array_unique(array_filter($id, static fn($x): bool => is_string($x) && $x !== '')));
        $count = count($id);

        return new BulkActionResult('Marked done '.$count.' item(s).', removedId: [], updatedId: $id);
    }
}
