<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */
namespace App\Service\Interfacing\Context;

use App\DomainInterface\Interfacing\Context\BaseContextProviderInterface;
use App\ServiceInterface\Interfacing\Context\BaseContextAssemblerInterface;

/**
 *
 */

/**
 *
 */
final readonly class BaseContextAssembler implements BaseContextAssemblerInterface
{
    /** @param iterable<BaseContextProviderInterface> $provider */
    public function __construct(private iterable $provider) {}

    /** @return array<string, mixed> */
    public function assemble(): array
    {
        $ctx = [];
        foreach ($this->provider as $p) {
            $data = $p->provide();
            foreach ($data as $k => $v) {
                $ctx[(string)$k] = $v;
            }
        }
        return $ctx;
    }
}
