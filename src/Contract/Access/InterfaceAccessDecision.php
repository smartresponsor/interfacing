<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Access;

final readonly class InterfaceAccessDecision
{
    public function __construct(
        public InterfaceAccessDecisionCode $code,
        public ?string $reason = null,
    ) {
    }

    public static function allow(?string $reason = null): self
    {
        return new self(InterfaceAccessDecisionCode::Allow, $reason);
    }

    public static function deny(string $reason): self
    {
        return new self(InterfaceAccessDecisionCode::Deny, $reason);
    }

    public static function defer(?string $reason = null): self
    {
        return new self(InterfaceAccessDecisionCode::Defer, $reason);
    }
}
