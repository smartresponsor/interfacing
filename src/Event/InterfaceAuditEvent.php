<?php

declare(strict_types=1);

namespace App\Interfacing\Event;

use App\Interfacing\Contract\Audit\InterfaceAuditEventType;

/**
 * Carries an immutable audit event emitted by Interfacing runtime surfaces.
 */
final readonly class InterfaceAuditEvent
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        public InterfaceAuditEventType $type,
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
        InterfaceAuditEventType $type,
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
