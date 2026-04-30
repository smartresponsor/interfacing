<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud;

use App\Interfacing\Contract\View\CrudResourceLinkSetInterface;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceContributionInterface;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceExplorerProviderInterface;

final readonly class CrudResourceExplorerProvider implements CrudResourceExplorerProviderInterface
{
    /** @param iterable<CrudResourceContributionInterface> $contributions */
    public function __construct(private iterable $contributions)
    {
    }

    public function provide(): array
    {
        $list = [];
        foreach ($this->contributions as $contribution) {
            if (!$contribution instanceof CrudResourceContributionInterface) {
                continue;
            }

            foreach ($contribution->provide() as $resource) {
                if ($resource instanceof CrudResourceLinkSetInterface) {
                    $list[] = $resource;
                }
            }
        }

        return $list;
    }
}
