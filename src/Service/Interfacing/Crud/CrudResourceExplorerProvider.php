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
        /** @var array<string, CrudResourceLinkSetInterface> $byId */
        $byId = [];

        foreach ($this->contributions as $contribution) {
            if (!$contribution instanceof CrudResourceContributionInterface) {
                continue;
            }

            foreach ($contribution->provide() as $resource) {
                if (!$resource instanceof CrudResourceLinkSetInterface) {
                    continue;
                }

                $current = $byId[$resource->id()] ?? null;
                if (null === $current || $this->priority($resource) > $this->priority($current)) {
                    $byId[$resource->id()] = $resource;
                }
            }
        }

        $list = array_values($byId);
        usort(
            $list,
            static fn (CrudResourceLinkSetInterface $left, CrudResourceLinkSetInterface $right): int => [
                $left->component(),
                $left->label(),
                $left->id(),
            ] <=> [
                $right->component(),
                $right->label(),
                $right->id(),
            ],
        );

        return $list;
    }

    private function priority(CrudResourceLinkSetInterface $resource): int
    {
        return match ($resource->status()) {
            'connected' => 300,
            'canonical' => 200,
            'planned' => 100,
            default => 0,
        };
    }
}
