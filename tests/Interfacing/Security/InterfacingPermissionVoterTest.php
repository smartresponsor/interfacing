<?php

declare(strict_types=1);

namespace App\Tests\Interfacing\Security;

use App\Application\Security\InterfacingPermissionVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class InterfacingPermissionVoterTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testAdminRoleAllowsAll(): void
    {
        $voter = new InterfacingPermissionVoter();
        $token = new TestToken(['ROLE_INTERFACING_ADMIN']);

        $ref = new \ReflectionClass($voter);
        $m = $ref->getMethod('voteOnAttribute');
        $m->setAccessible(true);

        self::assertTrue($m->invoke($voter, 'interfacing.screen.category-admin', null, $token));
        self::assertTrue($m->invoke($voter, 'interfacing.action.category-admin.save', null, $token));
    }

    /**
     * @throws \ReflectionException
     */
    public function testMappedRoleAllowsScreen(): void
    {
        $voter = new InterfacingPermissionVoter();
        $token = new TestToken(['ROLE_INTERFACING_SCREEN_CATEGORY_ADMIN']);

        $ref = new \ReflectionClass($voter);
        $m = $ref->getMethod('voteOnAttribute');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $m->setAccessible(true);

        self::assertTrue($m->invoke($voter, 'interfacing.screen.category-admin', null, $token));
        self::assertFalse($m->invoke($voter, 'interfacing.action.category-admin.save', null, $token));
    }

    /**
     * @throws \ReflectionException
     */
    public function testMappedRoleAllowsAction(): void
    {
        $voter = new InterfacingPermissionVoter();
        $token = new TestToken(['ROLE_INTERFACING_ACTION_CATEGORY_ADMIN_SAVE']);

        $ref = new \ReflectionClass($voter);
        $m = $ref->getMethod('voteOnAttribute');
        /* @noinspection PhpExpressionResultUnusedInspection */
        $m->setAccessible(true);

        self::assertTrue($m->invoke($voter, 'interfacing.action.category-admin.save', null, $token));
        self::assertFalse($m->invoke($voter, 'interfacing.screen.category-admin', null, $token));
    }
}

final class TestToken implements TokenInterface
{
    /**
     * @param list<string> $roles
     */
    public function __construct(private readonly array $roles)
    {
    }

    /**
     * @return string[]
     */
    public function getRoleNames(): array
    {
        return $this->roles;
    }

    public function getCredentials(): mixed
    {
        return null;
    }

    public function getUser(): mixed
    {
        return null;
    }

    public function setUser(mixed $user): void
    {
    }

    public function getUsername(): string
    {
        return '';
    }

    public function isAuthenticated(): bool
    {
        return true;
    }

    public function setAuthenticated(bool $isAuthenticated): void
    {
    }

    public function eraseCredentials(): void
    {
    }

    public function getAttributes(): array
    {
        return [];
    }

    public function setAttributes(array $attributes): void
    {
    }

    public function hasAttribute(string $name): bool
    {
        unset($name);

        return false;
    }

    public function getAttribute(string $name): mixed
    {
        unset($name);

        return null;
    }

    public function setAttribute(string $name, mixed $value): void
    {
        unset($name, $value);
    }

    public function __serialize(): array
    {
        return [];
    }

    public function __unserialize(array $data): void
    {
    }
}
