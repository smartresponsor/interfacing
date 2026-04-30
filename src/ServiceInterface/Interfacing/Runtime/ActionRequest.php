<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Runtime;

use Symfony\Component\HttpFoundation\Request;

final readonly class ActionRequest
{
    /**
     * @param array<string, mixed> $payload
     * @param array<string, mixed> $state
     * @param array<string, mixed> $context
     */
    public function __construct(
        public string $screenId,
        public string $actionId,
        public array $payload,
        public array $state = [],
        public array $context = [],
        public ?Request $request = null,
    ) {
    }
}
