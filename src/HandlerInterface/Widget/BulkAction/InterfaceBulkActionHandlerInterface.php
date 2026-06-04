<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\HandlerInterface\Widget\BulkAction;

use App\Interfacing\Contract\Dto\InterfaceBulkActionResult;

interface InterfaceBulkActionHandlerInterface
{
    public function id(): string;

    /**
     * @param list<string> $id
     */
    public function execute(array $id, array $context = []): InterfaceBulkActionResult;
}
