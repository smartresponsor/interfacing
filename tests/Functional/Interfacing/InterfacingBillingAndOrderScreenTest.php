<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Tests\Functional\Interfacing;

use App\Interfacing\Contract\Access\AccessDecision;
use App\Interfacing\Contract\Dto\BillingMeterPage;
use App\Interfacing\Contract\Dto\BillingMeterRow;
use App\Interfacing\Contract\Dto\OrderSummaryPage;
use App\Interfacing\Contract\Dto\OrderSummaryRow;
use App\Interfacing\ServiceInterface\Interfacing\Access\AccessResolverInterface;
use App\Interfacing\ServiceInterface\Interfacing\Context\RequestBaseContextProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Query\BillingMeterQueryServiceInterface;
use App\Interfacing\ServiceInterface\Interfacing\Query\OrderSummaryQueryServiceInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

#[CoversClass(\App\Interfacing\Presentation\Controller\Interfacing\BillingMeterScreenController::class)]
#[CoversClass(\App\Interfacing\Presentation\Controller\Interfacing\OrderSummaryScreenController::class)]
final class InterfacingBillingAndOrderScreenTest extends WebTestCase
{
    public function testBillingMeterScreenRendersWithStubData(): void
    {
        $client = $this->createClientWithStubs();

        $client->request('GET', '/interfacing/billing/meter');

        self::assertResponseIsSuccessful();
        $content = (string) $client->getResponse()->getContent();

        self::assertStringContainsString('CRUD Workbench · Billing / Meter', $content);
        self::assertStringContainsString('mtr-1', $content);
        self::assertStringContainsString('active', $content);
        self::assertStringContainsString('mtr-2', $content);
        self::assertStringContainsString('closed', $content);
        self::assertStringContainsString('Ant Design / ProComponents discipline', $content);
        self::assertStringContainsString('Register meter', $content);
        self::assertStringContainsString('Next reading step', $content);
        self::assertStringContainsString('Shared Twig discipline', $content);
        self::assertStringContainsString('route semantics', $content);
        self::assertStringContainsString('mode-aware actions', $content);
        self::assertStringContainsString('surface-aware density', $content);
        self::assertStringContainsString('identifier-aware addressing', $content);
        self::assertStringContainsString('Consumer-safe public surface', $content);
        self::assertStringContainsString('billing/meter', $content);
        self::assertStringContainsString('operation: index', $content);
        self::assertStringContainsString('Showing 2 of 2 meter readings in the current operational window', $content);
        self::assertStringContainsString('Reading route context', $content);
        self::assertStringContainsString('Reading command form', $content);
        self::assertStringContainsString('Resource-aware form schema keeps edit/new fields aligned to the selected CRUD resource.', $content);
        self::assertStringContainsString('Downstream settlement marker for the current reading.', $content);
        self::assertStringContainsString('template intent: workbench.index', $content);
        self::assertStringContainsString('access mode: interactive', $content);
        self::assertStringContainsString('Meter readings browse capability', $content);
        self::assertStringContainsString('Reading state', $content);
        self::assertStringContainsString('Window from', $content);
        self::assertStringContainsString('Window to', $content);
        self::assertStringContainsString('Meter ref', $content);
        self::assertStringContainsString('Billed amount', $content);
        self::assertStringContainsString('Settlement state', $content);
        self::assertStringContainsString('Measurement-safe vocabulary for readings, windows, and settlement cues.', $content);
        self::assertStringContainsString('resource tone: Reading and measurement lifecycle copy', $content);
        self::assertStringContainsString('Reading state', $content);
        self::assertStringContainsString('Window from', $content);
        self::assertStringContainsString('Window to', $content);
        self::assertStringContainsString('Meter ref', $content);
        self::assertStringContainsString('Billed amount', $content);
        self::assertStringContainsString('Measurement-safe vocabulary for readings, windows, and settlement cues.', $content);
        self::assertStringContainsString('Showing 2 of 2 meter readings in the current operational window', $content);
        self::assertStringContainsString('Reading route context', $content);
        self::assertStringContainsString('Reading command form', $content);
        self::assertStringContainsString('Downstream settlement marker for the current reading.', $content);
        self::assertStringContainsString('template intent: workbench.index', $content);
        self::assertStringContainsString('access mode: interactive', $content);
        self::assertStringContainsString('Meter readings browse capability', $content);
    }

    public function testOrderSummaryScreenRendersWithStubData(): void
    {
        $client = $this->createClientWithStubs();

        $client->request('GET', '/interfacing/order/summary');

        self::assertResponseIsSuccessful();
        $content = (string) $client->getResponse()->getContent();

        self::assertStringContainsString('CRUD Workbench · Sales / Order', $content);
        self::assertStringContainsString('ord-1', $content);
        self::assertStringContainsString('USD', $content);
        self::assertStringContainsString('customer@example.test', $content);
        self::assertStringContainsString('Ant Design / ProComponents discipline', $content);
        self::assertStringContainsString('Create order', $content);
        self::assertStringContainsString('Next order step', $content);
        self::assertStringContainsString('Shared Twig discipline', $content);
        self::assertStringContainsString('route semantics', $content);
        self::assertStringContainsString('mode-aware actions', $content);
        self::assertStringContainsString('surface-aware density', $content);
        self::assertStringContainsString('identifier-aware addressing', $content);
        self::assertStringContainsString('Consumer-safe public surface', $content);
        self::assertStringContainsString('sales/order', $content);
        self::assertStringContainsString('operation: index', $content);
        self::assertStringContainsString('Showing 2 of 2 orders in the current request window', $content);
        self::assertStringContainsString('Request route context', $content);
        self::assertStringContainsString('Order command form', $content);
        self::assertStringContainsString('Resource-aware form schema keeps edit/new fields aligned to the selected CRUD resource.', $content);
        self::assertStringContainsString('Internal reference for order routing.', $content);
        self::assertStringContainsString('template intent: workbench.index', $content);
        self::assertStringContainsString('Orders browse capability', $content);
    }


    public function testOrderSummaryScreenSupportsFormModePreviewOverrides(): void
    {
        $client = $this->createClientWithStubs();

        $client->request('GET', '/interfacing/order/summary?_crud_operation=edit&_crud_surface=admin&selected=ord-2');

        self::assertResponseIsSuccessful();
        $content = (string) $client->getResponse()->getContent();

        self::assertStringContainsString('Form mode: command-centered edit/new surface', $content);
        self::assertStringContainsString('operation: edit', $content);
        self::assertStringContainsString('identifier kind: Operator/internal id addressing', $content);
        self::assertStringContainsString('surface: admin', $content);
        self::assertStringContainsString('Operational admin surface', $content);
        self::assertStringContainsString('ord-2', $content);
        self::assertStringContainsString('Save order draft', $content);
        self::assertStringContainsString('Cancel', $content);
        self::assertStringContainsString('Validation and section review', $content);
        self::assertStringContainsString('Request identity', $content);
        self::assertStringContainsString('Workflow and intake', $content);
        self::assertStringContainsString('Commercial context', $content);
        self::assertStringContainsString('required', $content);
        self::assertStringNotContainsString('Next', $content);
    }

    public function testBillingMeterScreenSupportsDestructiveModePreviewOverrides(): void
    {
        $client = $this->createClientWithStubs();

        $client->request('GET', '/interfacing/billing/meter?_crud_operation=delete&_crud_surface=admin&selected=mtr-2');

        self::assertResponseIsSuccessful();
        $content = (string) $client->getResponse()->getContent();

        self::assertStringContainsString('Delete confirmation surface', $content);
        self::assertStringContainsString('Operator/internal id addressing', $content);
        self::assertStringContainsString('operation: delete', $content);
        self::assertStringContainsString('surface: admin', $content);
        self::assertStringContainsString('Operational admin surface', $content);
        self::assertStringContainsString('mtr-2', $content);
        self::assertStringContainsString('Back to meters', $content);
        self::assertStringContainsString('Only destructive-safe actions stay visible in this mode.', $content);
        self::assertStringContainsString('Retirement target', $content);
        self::assertStringNotContainsString('Register meter', $content);
        self::assertStringNotContainsString('Next reading step', $content);
    }


    public function testOrderSummaryScreenSupportsPublicFormModePreviewOverrides(): void
    {
        $client = $this->createClientWithStubs();

        $client->request('GET', '/interfacing/order/summary?_crud_operation=edit&_crud_surface=public&selected=ord-2');

        self::assertResponseIsSuccessful();
        $content = (string) $client->getResponse()->getContent();

        self::assertStringContainsString('Form mode: command-centered edit/new surface', $content);
        self::assertStringContainsString('surface: public', $content);
        self::assertStringContainsString('Consumer-safe public surface', $content);
        self::assertStringContainsString('Submit order update', $content);
        self::assertStringContainsString('Preview order', $content);
        self::assertStringContainsString('Validation and section review', $content);
        self::assertStringContainsString('Request identity', $content);
        self::assertStringNotContainsString('Save order draft', $content);
    }

    public function testBillingMeterScreenSupportsPublicDestructiveModePreviewOverrides(): void
    {
        $client = $this->createClientWithStubs();

        $client->request('GET', '/interfacing/billing/meter?_crud_operation=delete&_crud_surface=public&selected=mtr-2');

        self::assertResponseIsSuccessful();
        $content = (string) $client->getResponse()->getContent();

        self::assertStringContainsString('Public-safe destructive review surface', $content);
        self::assertStringContainsString('Operator/internal id addressing', $content);
        self::assertStringContainsString('surface: public', $content);
        self::assertStringContainsString('Consumer-safe public surface', $content);
        self::assertStringContainsString('Archive request', $content);
        self::assertStringContainsString('Public surface keeps only review-safe actions visible in this mode.', $content);
        self::assertStringContainsString('Retirement target', $content);
        self::assertStringNotContainsString('Only destructive-safe actions stay visible in this mode.', $content);
    }


    public function testOrderSummaryScreenSupportsSlugAddressingPreviewOverrides(): void
    {
        $client = $this->createClientWithStubs();

        $client->request('GET', '/interfacing/order/summary?_crud_operation=show&_crud_surface=public&slug=summer-order');

        self::assertResponseIsSuccessful();
        $content = (string) $client->getResponse()->getContent();

        self::assertStringContainsString('SEO/public slug addressing', $content);
        self::assertStringContainsString('summer-order', $content);
        self::assertStringContainsString('breadcrumb: CRUD › Sales › Order › Show › summer-order', $content);
        self::assertStringContainsString('resource label: Sales / Order', $content);
        self::assertStringContainsString('resource tone: Transaction and request lifecycle copy', $content);
    }

    private function createClientWithStubs(): KernelBrowser
    {
        self::ensureKernelShutdown();

        $client = self::createClient([
            'environment' => 'test',
            'debug' => true,
        ]);
        $container = self::getContainer();

        // Access: always allow in tests.
        $accessResolver = new TestAllowAllAccessResolver();

        if ($container->has(AccessResolverInterface::class)) {
            $container->set(AccessResolverInterface::class, $accessResolver);
        }

        // Context: stable tenant/user for tests, so no env or security dependency.
        $baseContextProvider = new TestBaseContextProvider();

        if ($container->has(RequestBaseContextProviderInterface::class)) {
            $container->set(RequestBaseContextProviderInterface::class, $baseContextProvider);
        }

        // Billing & order query services: provide in-memory pages instead of HTTP calls.
        $billingQuery = new TestBillingMeterQueryService();
        $orderQuery = new TestOrderSummaryQueryService();

        if ($container->has(BillingMeterQueryServiceInterface::class)) {
            $container->set(BillingMeterQueryServiceInterface::class, $billingQuery);
        }

        if ($container->has(OrderSummaryQueryServiceInterface::class)) {
            $container->set(OrderSummaryQueryServiceInterface::class, $orderQuery);
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
final class TestBaseContextProvider implements RequestBaseContextProviderInterface
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
