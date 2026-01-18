<?php
declare(strict_types=1);

namespace SmartResponsor\Interfacing\Domain\Interfacing\Audit;

final class AuditEvent
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        public readonly AuditEventType $type,
        public readonly string $atIso8601,
        public readonly string $tenantId,
        public readonly ?string $userId,
        public readonly ?string $screenId,
        public readonly ?string $actionId,
        public readonly array $data,
    ) {}

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
