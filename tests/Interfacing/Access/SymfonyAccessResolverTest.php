<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Access;

use App\Interfacing\Contract\Access\AccessDecisionCode;
use App\Interfacing\Service\Interfacing\Access\SymfonyAccessResolver;
use App\Interfacing\ServiceInterface\Interfacing\Security\PermissionNamerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

final class SymfonyAccessResolverTest extends TestCase
{
    public function testPublicScreensAreAllowedWithoutAuthenticatedRole(): void
    {
        $resolver = new SymfonyAccessResolver(new class implements PermissionNamerInterface {
            public function screen(string $screenId): string { return 'interfacing.screen.'.$screenId; }
            public function action(string $screenId, string $actionId): string { return 'interfacing.action.'.$screenId.'.'.$actionId; }
            public function normalizeId(string $raw): string { return $raw; }
        }, null);

        $decision = $resolver->canOpenScreen('order-summary', Request::create('/interfacing/order/summary'), null);

        self::assertSame(AccessDecisionCode::Allow, $decision->code);
        self::assertSame('public', $decision->reason);
    }
}
