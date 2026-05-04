<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * Neutral preview row for the generic CRUD workbench bridge.
 *
 * The generic Interfacing bridge must not depend on an order-specific DTO
 * shape. Owning components can map their own query/read models into this
 * neutral row contract before the workbench view is built.
 */
final readonly class CrudPreviewRow
{
    public function __construct(
        public string $identifier,
        public string $status,
        public string $occurredAtIso,
        public float $amountValue,
        public string $currencyCode,
        public ?string $actorLabel = null,
    ) {
    }
}
