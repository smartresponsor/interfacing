<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Crud;

use App\Interfacing\Contract\View\InterfaceCrudResourceLinkSetInterface;

interface InterfaceCrudResourceExplorerProviderInterface
{
    /**
     * @return list<InterfaceCrudResourceLinkSetInterface>
     */
    public function provide(): array;
}
