<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Search;

interface InterfaceSearchHandoffProviderInterface
{
    /**
     * @return array<string, mixed>
     */
    public function getSurfaceConfig(array $context = []): array;

    /**
     * @param array<string, mixed> $criteria
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>
     */
    public function search(array $criteria = [], array $context = []): array;

    /**
     * @param array<string, mixed> $criteria
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>
     */
    public function suggest(array $criteria = [], array $context = []): array;
}
