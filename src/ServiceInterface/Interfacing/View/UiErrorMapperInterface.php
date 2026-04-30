<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\ServiceInterface\Interfacing\View;

interface UiErrorMapperInterface
{
    /**
     * @return array{status:int,code:string,title:string,detail:string,traceId:?string}
     */
    public function map(\Throwable $e, ?string $traceId = null): array;
}
