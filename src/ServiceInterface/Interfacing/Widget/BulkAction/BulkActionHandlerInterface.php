<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\BulkAction;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\BulkAction\BulkActionResult;

interface BulkActionHandlerInterface
{
    public function id(): string;

    /**
     * @param list<string> $id
     */
    public function execute(array $id, array $context = []): BulkActionResult;
}
