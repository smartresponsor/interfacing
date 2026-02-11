<?php
declare(strict_types=1);

namespace App\Tests\Interfacing\Security;

use App\Infra\Interfacing\Security\InterfacingPermissionVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 *
 */

/**
 *
 */
final class InterfacingPermissionVoterTest extends TestCase
{
    /**
     * @return void
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
     * @return void
     * @throws \ReflectionException
     */
    public function testMappedRoleAllowsScreen(): void
    {
        $voter = new InterfacingPermissionVoter();
        $token = new TestToken(['ROLE_INTERFACING_SCREEN_CATEGORY_ADMIN']);

        $ref = new \ReflectionClass($voter);
        $m = $ref->getMethod('voteOnAttribute');
        $m->setAccessible(true);

        self::assertTrue($m->invoke($voter, 'interfacing.screen.category-admin', null, $token));
        self::assertFalse($m->invoke($voter, 'interfacing.action.category-admin.save', null, $token));
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function testMappedRoleAllowsAction(): void
    {
        $voter = new InterfacingPermissionVoter();
        $token = new TestToken(['ROLE_INTERFACING_ACTION_CATEGORY_ADMIN_SAVE']);

        $ref = new \ReflectionClass($voter);
        $m = $ref->getMethod('voteOnAttribute');
        $m->setAccessible(true);

        self::assertTrue($m->invoke($voter, 'interfacing.action.category-admin.save', null, $token));
        self::assertFalse($m->invoke($voter, 'interfacing.screen.category-admin', null, $token));
    }
}

/**
 *
 */

/**
 *
 */
final class TestToken implements TokenInterface
{
    /**
     * @param list<string> $roles
     */
    public function __construct(private readonly array $roles) {}

    /**
     * @return string[]
     */
    public function getRoleNames(): array { return $this->roles; }

    /**
     * @return mixed
     */
    public function getCredentials(): mixed { return null; }

    /**
     * @return mixed
     */
    public function getUser(): mixed { return null; }

    /**
     * @param mixed $user
     * @return void
     */
    public function setUser(mixed $user): void {}

    /**
     * @return string
     */
    public function getUsername(): string { return ''; }

    /**
     * @return bool
     */
    public function isAuthenticated(): bool { return true; }

    /**
     * @param bool $isAuthenticated
     * @return void
     */
    public function setAuthenticated(bool $isAuthenticated): void {}

    /**
     * @return void
     */
    public function eraseCredentials(): void {}

    /**
     * @return array
     */
    public function getAttributes(): array { return []; }

    /**
     * @param array $attributes
     * @return void
     */
    public function setAttributes(array $attributes): void {}

    /**
     * @param string $name
     * @return bool
     */
    public function hasAttribute(string $name): bool { return false; }

    /**
     * @param string $name
     * @return mixed
     */
    public function getAttribute(string $name): mixed { return null; }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setAttribute(string $name, mixed $value): void {}

    /**
     * @return array
     */
    public function __serialize(): array { return []; }

    /**
     * @param array $data
     * @return void
     */
    public function __unserialize(array $data): void {}
}
