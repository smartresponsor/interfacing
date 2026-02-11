<?php
declare(strict_types=1);

namespace App\Domain\Interfacing\Access;

/**
 *
 */

/**
 *
 */
final readonly class AccessDecision
{
    /**
     * @param \App\Domain\Interfacing\Access\AccessDecisionCode $code
     * @param string|null $reason
     */
    public function __construct(
        public AccessDecisionCode $code,
        public ?string            $reason = null,
    ) {}

    /**
     * @param string|null $reason
     * @return self
     */
    public static function allow(?string $reason = null): self
    {
        return new self(AccessDecisionCode::Allow, $reason);
    }

    /**
     * @param string $reason
     * @return self
     */
    public static function deny(string $reason): self
    {
        return new self(AccessDecisionCode::Deny, $reason);
    }

    /**
     * @param string|null $reason
     * @return self
     */
    public static function defer(?string $reason = null): self
    {
        return new self(AccessDecisionCode::Defer, $reason);
    }
}
