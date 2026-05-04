<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\View;

use Symfony\Component\HttpFoundation\Request;

interface GenericCrudWorkbenchViewBuilderInterface
{
    /** @return array{screenId:string,ctx:array<string, mixed>,workbench:mixed} */
    public function build(Request $request): array;
}
