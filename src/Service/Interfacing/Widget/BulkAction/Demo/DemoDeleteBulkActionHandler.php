<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Service\Interfacing\Widget\BulkAction\Demo;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\BulkAction\BulkActionResult;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\BulkAction\BulkActionHandlerInterface;

final class DemoDeleteBulkActionHandler implements BulkActionHandlerInterface
{
    public function id(): string
    {
        return 'demo-delete';
    }

    public function execute(array $id, array $context = []): BulkActionResult
    {
        $id = array_values(array_unique(array_filter($id, static fn($x): bool => is_string($x) && $x !== '')));
        $count = count($id);

        return new BulkActionResult('Deleted '.$count.' item(s).', removedId: $id, updatedId: []);
    }
}
