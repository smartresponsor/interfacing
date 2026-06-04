<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\Contract\Access\InterfaceAccessDecisionCode;
use App\Interfacing\Contract\Audit\InterfaceAuditEvent;
use App\Interfacing\Contract\Audit\InterfaceAuditEventType;
use App\Interfacing\Factory\Crud\InterfaceCrudWorkbenchFactory;
use App\Interfacing\ProviderInterface\Context\InterfaceRequestBaseContextProviderInterface;
use App\Interfacing\Resolver\Crud\InterfaceCrudRouteContextResolver;
use App\Interfacing\Resolver\Crud\InterfaceCrudScreenContextResolver;
use App\Interfacing\ResolverInterface\Access\InterfaceScreenActionAccessResolverInterface;
use App\Interfacing\ServiceInterface\Query\InterfaceOrderSummaryQueryServiceInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use App\Interfacing\SinkInterface\Audit\InterfaceAuditSinkInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class InterfaceOrderSummaryScreenController extends AbstractController
{
    private const InterfaceScreenId = 'order-summary';

    public function __construct(
        private readonly InterfaceRequestBaseContextProviderInterface $baseContext,
        private readonly InterfaceScreenActionAccessResolverInterface $access,
        private readonly InterfaceOrderSummaryQueryServiceInterface $orders,
        private readonly InterfaceCrudRouteContextResolver $routeContextResolver,
        private readonly InterfaceCrudWorkbenchFactory $workbenchFactory,
        private readonly InterfaceCrudScreenContextResolver $screenContextResolver,
        private readonly InterfaceAuditSinkInterface $audit,
        private readonly InterfaceRendererInterface $renderer,
        private readonly ?TokenStorageInterface $tokenStorage = null,
    ) {
    }

    #[Route(path: '/interfacing/order/summary', name: 'interfacing_order_summary', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $token = $this->tokenStorage?->getToken();
        $ctx = $this->baseContext->provide($request, $token);

        $tenantId = (string) ($ctx['tenantId'] ?? 'default');
        $userId = isset($ctx['userId']) ? (string) $ctx['userId'] : null;

        $decision = $this->access->canOpenScreen(self::InterfaceScreenId, $request, $token);
        if (InterfaceAccessDecisionCode::Allow !== $decision->code) {
            throw $this->createAccessDeniedException($decision->reason ?? 'Access denied.');
        }

        $page = (int) $request->query->get('page', 1);
        if ($page < 1) {
            $page = 1;
        }

        $pageSize = (int) $request->query->get('pageSize', 25);
        if ($pageSize < 1 || $pageSize > 200) {
            $pageSize = 25;
        }

        $status = (string) $request->query->get('status', '');
        $createdFrom = (string) $request->query->get('createdFrom', '');
        $createdTo = (string) $request->query->get('createdTo', '');

        $statusFilter = '' !== $status ? $status : null;
        $createdFromFilter = '' !== $createdFrom ? $createdFrom : null;
        $createdToFilter = '' !== $createdTo ? $createdTo : null;

        $pageData = $this->orders->fetchPage(
            $tenantId,
            $page,
            $pageSize,
            $statusFilter,
            $createdFromFilter,
            $createdToFilter,
        );

        $this->audit->record(InterfaceAuditEvent::now(
            InterfaceAuditEventType::ScreenOpen,
            $tenantId,
            $userId,
            self::InterfaceScreenId,
            null,
            [
                'path' => $request->getPathInfo(),
                'ip' => (string) $request->getClientIp(),
                'page' => $page,
                'pageSize' => $pageSize,
                'status' => $statusFilter,
                'createdFrom' => $createdFromFilter,
                'createdTo' => $createdToFilter,
            ],
        ));

        $filters = [
            'status' => $status,
            'createdFrom' => $createdFrom,
            'createdTo' => $createdTo,
        ];

        $routeContext = $this->routeContextResolver->resolve($request, 'sales/order');
        $screenContext = $this->screenContextResolver->resolve($request, $routeContext);

        return $this->renderer->render('order/summary.html.twig', [
            'screenId' => self::InterfaceScreenId,
            'ctx' => $ctx,
            'workbench' => $this->workbenchFactory->buildOrderSummaryView(
                $pageData,
                $filters,
                $ctx,
                $routeContext,
                $screenContext,
            ),
        ]);
    }
}
