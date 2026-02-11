<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\ServiceInterface\Interfacing\Runtime;

    use Symfony\Component\HttpFoundation\Request;

final class ActionRequest
{
    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        public readonly string $screenId,
        public readonly string $actionId,
        public readonly array $payload,
        public readonly Request $request,
    ) {
    }
}

