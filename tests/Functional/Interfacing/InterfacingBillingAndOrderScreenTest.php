<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Tests\Functional\Interfacing;

use App\Contract\Access\AccessDecision;
use App\Contract\Dto\BillingMeterPage;
use App\Contract\Dto\BillingMeterRow;
use App\Contract\Dto\OrderSummaryPage;
use App\Contract\Dto\OrderSummaryRow;
use App\ServiceInterface\Interfacing\Access\AccessResolverInterface;
use App\ServiceInterface\Interfacing\Query\BillingMeterQueryServiceInterface;
use App\ServiceInterface\Interfacing\Query\OrderSummaryQueryServiceInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

#[CoversClass(\App\Presentation\Controller\Interfacing\BillingMeterScreenController::class)]
#[CoversClass(\App\Presentation\Controller\Interfacing\OrderSummaryScreenController::class)]
final class InterfacingBillingAndOrderScreenTest extends WebTestCase
{
    public function testBillingMeterScreenRendersWithStubData(): void
    {
        $client = $this->createClientWithStubs();

        $client->request('GET', '/interfacing/billing/meter');

        self::assertResponseIsSuccessful();
        $content = (string) $client->getResponse()->getContent();

        self::assertStringContainsString('Billing meter screen', $content);
        self::assertStringContainsString('mtr-1', $content);
        self::assertStringContainsString('active', $content);
        self::assertStringContainsString('mtr-2', $content);
        self::assertStringContainsString('closed', $content);
    }

    public function testOrderSummaryScreenRendersWithStubData(): void
    {
        $client = $this->createClientWithStubs();

        $client->request('GET', '/interfacing/order/summary');

        self::assertResponseIsSuccessful();
        $content = (string) $client->getResponse()->getContent();

        self::assertStringContainsString('Order summary screen', $content);
        self::assertStringContainsString('ord-1', $content);
        self::assertStringContainsString('USD', $content);
        self::assertStringContainsString('customer@example.test', $content);
    }

    private function createClientWithStubs(): KernelBrowser
    {
        self::ensureKernelShutdown();

        $client = self::createClient();
        $container = self::getContainer();

        // Access: always allow in tests.
        $accessResolver = new TestAllowAllAccessResolver();

        if ($container->has(AccessResolverInterface::class)) {
            $container->set(AccessResolverInterface::class, $accessResolver);
        }

        if ($container->has('App\\Service\\Interfacing\\Access\\SymfonyAccessResolver')) {
            $container->set('App\\Service\\Interfacing\\Access\\SymfonyAccessResolver', $accessResolver);
        }

        // Context: stable tenant/user for tests, so no env or security dependency.
        $baseContextProvider = new TestBaseContextProvider();

        if ($container->has(BaseContextProviderInterface::class)) {
            $container->set(BaseContextProviderInterface::class, $baseContextProvider);
        }

        if ($container->has('App\\Service\\Interfacing\\Context\\SymfonyBaseContextProvider')) {
            $container->set('App\\Service\\Interfacing\\Context\\SymfonyBaseContextProvider', $baseContextProvider);
        }

        // Billing & order query services: provide in-memory pages instead of HTTP calls.
        $billingQuery = new TestBillingMeterQueryService();
        $orderQuery = new TestOrderSummaryQueryService();

        if ($container->has(BillingMeterQueryServiceInterface::class)) {
            $container->set(BillingMeterQueryServiceInterface::class, $billingQuery);
        }

        if ($container->has('App\\Service\\Interfacing\\Query\\HttpBillingMeterQueryService')) {
            $container->set('App\\Service\\Interfacing\\Query\\HttpBillingMeterQueryService', $billingQuery);
        }

        if ($container->has(OrderSummaryQueryServiceInterface::class)) {
            $container->set(OrderSummaryQueryServiceInterface::class, $orderQuery);
        }

        if ($container->has('App\\Service\\Interfacing\\Query\\HttpOrderSummaryQueryService')) {
            $container->set('App\\Service\\Interfacing\\Query\\HttpOrderSummaryQueryService', $orderQuery);
        }

        return $client;
    }
}

/**
 * Test-only AccessResolver that always allows the requested action.
 */
final class TestAllowAllAccessResolver implements AccessResolverInterface
{
    public function canOpenScreen(string $screenId, Request $request, ?TokenInterface $token): AccessDecision
    {
        return AccessDecision::allow('test-open:'.$screenId);
    }

    public function canRunAction(string $screenId, string $actionId, Request $request, ?TokenInterface $token): AccessDecision
    {
        return AccessDecision::allow('test-action:'.$screenId.'#'.$actionId);
    }
}

/**
 * Test-only context provider with a fixed tenant and synthetic user.
 */
final class TestBaseContextProvider implements BaseContextProviderInterface
{
    /**
     * @return array|mixed[]
     */
    public function provide(Request $request, ?TokenInterface $token): array
    {
        $userId = $token?->getUserIdentifier() ?? 'interfacing-test-user';

        return [
            'tenantId' => 'interfacing-test-tenant',
            'userId' => $userId,
            'sourceIp' => $request->getClientIp(),
            'scopes' => ['interfacing:billing', 'interfacing:order'],
        ];
    }
}

/**
 * In-memory BillingMeter query service for functional tests.
 */
final class TestBillingMeterQueryService implements BillingMeterQueryServiceInterface
{
    public function fetchPage(
        string $tenantId,
        int $page,
        int $pageSize,
        ?string $status,
        ?string $periodFromIso,
        ?string $periodToIso,
    ): BillingMeterPage {
        $rows = [
            new BillingMeterRow('mtr-1', 'active', 123.45, '2025-01-01', '2025-01-31'),
            new BillingMeterRow('mtr-2', 'closed', 67.89, '2025-02-01', '2025-02-28'),
        ];

        return new BillingMeterPage(
            $rows,
            total: count($rows),
            page: 1,
            pageSize: $pageSize > 0 ? $pageSize : 50,
        );
    }
}

/**
 * In-memory OrderSummary query service for functional tests.
 */
final class TestOrderSummaryQueryService implements OrderSummaryQueryServiceInterface
{
    public function fetchPage(
        string $tenantId,
        int $page,
        int $pageSize,
        ?string $status,
        ?string $createdFromIso,
        ?string $createdToIso,
    ): OrderSummaryPage {
        $rows = [
            new OrderSummaryRow(
                'ord-1',
                'paid',
                '2025-01-10T12:00:00+00:00',
                199.99,
                'USD',
                'customer@example.test'
            ),
            new OrderSummaryRow(
                'ord-2',
                'pending',
                '2025-01-12T08:30:00+00:00',
                49.00,
                'USD',
                null
            ),
        ];

        return new OrderSummaryPage(
            $rows,
            total: count($rows),
            page: 1,
            pageSize: $pageSize > 0 ? $pageSize : 50,
        );
    }
}
