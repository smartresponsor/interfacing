<?php

declare(strict_types=1);

namespace App\Interfacing\AssemblerInterface\Context;

interface InterfaceScreenContextAssemblerInterface
{
    /** @return array<string, mixed> */
    public function assemble(string $screenId): array;
}
