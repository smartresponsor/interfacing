<?php

declare(strict_types=1);

namespace App\Application\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class InterfacingPermissionVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        unset($subject);
        if (InterfacingPermission::RoleAdmin === $attribute) {
            return true;
        }

        return str_starts_with($attribute, InterfacingPermission::PrefixScreen)
            || str_starts_with($attribute, InterfacingPermission::PrefixAction);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        unset($vote);
        unset($subject);
        $roles = $token->getRoleNames();

        if (in_array(InterfacingPermission::RoleAdmin, $roles, true)) {
            return true;
        }

        $mappedRole = $this->mapAttributeToRole($attribute);

        return null !== $mappedRole && in_array($mappedRole, $roles, true);
    }

    private function mapAttributeToRole(string $attribute): ?string
    {
        $attribute = strtolower(trim($attribute));
        if ('' === $attribute) {
            return null;
        }

        if (str_starts_with($attribute, InterfacingPermission::PrefixScreen)) {
            $tail = substr($attribute, strlen(InterfacingPermission::PrefixScreen));
            $tail = $this->toUpperSnake($tail);

            return 'ROLE_INTERFACING_SCREEN_'.$tail;
        }

        if (str_starts_with($attribute, InterfacingPermission::PrefixAction)) {
            $tail = substr($attribute, strlen(InterfacingPermission::PrefixAction));
            $tail = $this->toUpperSnake(str_replace('.', '_', $tail));

            return 'ROLE_INTERFACING_ACTION_'.$tail;
        }

        return null;
    }

    private function toUpperSnake(string $value): string
    {
        $value = preg_replace('/[^a-z0-9]+/i', '_', $value) ?? $value;
        $value = preg_replace('/_+/', '_', $value) ?? $value;
        $value = trim($value, '_');

        return strtoupper($value);
    }
}
