<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\ServiceInterface\Interfacing\Runtime;

    use Symfony\Component\HttpFoundation\Request;

    /**
     *
     */

    /**
     *
     */
    final readonly class ActionRequest
{
    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        public string  $screenId,
        public string  $actionId,
        public array   $payload,
        public Request $request,
    ) {
    }
}

