<?php

declare(strict_types=1);

namespace App\Interfacing\ProviderInterface\Messaging;

interface InterfaceMessagingShowcaseProviderInterface
{
    /**
     * @param array<string, mixed> $criteria
     *
     * @return array<string, mixed>
     */
    public function provide(array $criteria = []): array;
}
