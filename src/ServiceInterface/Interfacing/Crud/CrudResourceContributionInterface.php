<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Crud;

use App\Interfacing\Contract\View\CrudResourceLinkSetInterface;

interface CrudResourceContributionInterface
{
    /**
     * @return list<CrudResourceLinkSetInterface>
     */
    public function provide(): array;
}
