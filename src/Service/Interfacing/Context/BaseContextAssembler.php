<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Context;

use App\ServiceInterface\Interfacing\Context\BaseContextAssemblerInterface;
use App\ServiceInterface\Interfacing\Context\BaseContextProviderInterface;

final readonly class BaseContextAssembler implements BaseContextAssemblerInterface
{
    /** @param iterable<BaseContextProviderInterface> $provider */
    public function __construct(private iterable $provider)
    {
    }

    public function assemble(): array
    {
        $ctx = [];
        foreach ($this->provider as $p) {
            $data = $p->provide();
            foreach ($data as $k => $v) {
                $ctx[(string) $k] = $v;
            }
        }

        return $ctx;
    }
}
