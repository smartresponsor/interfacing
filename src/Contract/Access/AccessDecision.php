<?php

declare(strict_types=1);

namespace App\Contract\Access;

final readonly class AccessDecision
{
    public function __construct(
        public AccessDecisionCode $code,
        public ?string $reason = null,
    ) {
    }

    public static function allow(?string $reason = null): self
    {
        return new self(AccessDecisionCode::Allow, $reason);
    }

    public static function deny(string $reason): self
    {
        return new self(AccessDecisionCode::Deny, $reason);
    }

    public static function defer(?string $reason = null): self
    {
        return new self(AccessDecisionCode::Defer, $reason);
    }
}
