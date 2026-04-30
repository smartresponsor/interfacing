<?php

declare(strict_types=1);

namespace App\Interfacing\Support\Audit;

final readonly class AuditEvent
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        public AuditEventType $type,
        public string $atIso8601,
        public string $tenantId,
        public ?string $userId,
        public ?string $screenId,
        public ?string $actionId,
        public array $data,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function now(
        AuditEventType $type,
        string $tenantId,
        ?string $userId,
        ?string $screenId,
        ?string $actionId,
        array $data,
    ): self {
        return new self(
            $type,
            (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))->format(DATE_ATOM),
            $tenantId,
            $userId,
            $screenId,
            $actionId,
            $data,
        );
    }
}
