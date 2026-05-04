<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * Canonical resource descriptor published by owning components for the generic CRUD bridge.
 *
 * This descriptor is intentionally URL-free. URL generation belongs to the Interfacing
 * provider layer so component contributions only describe resource identity, route grammar,
 * status, and sample identity.
 */
interface CrudResourceDescriptorInterface
{
    public function id(): string;

    public function component(): string;

    public function label(): string;

    public function resourcePath(): string;

    public function indexRoute(): string;

    public function indexFallback(): string;

    public function newRoute(): string;

    public function newFallback(): string;

    public function showPattern(): string;

    public function editPattern(): string;

    public function deletePattern(): string;

    /** @return array<string, string> */
    public function routeParameters(): array;

    public function note(): ?string;

    public function status(): string;

    public function sampleIdentifier(): string;
}
