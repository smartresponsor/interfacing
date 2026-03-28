<?php

declare(strict_types=1);

namespace App\ServiceInterface\Interfacing\Context;

interface ScreenContextAssemblerInterface
{
    /** @return array<string, mixed> */
    public function assemble(string $screenId): array;
}
