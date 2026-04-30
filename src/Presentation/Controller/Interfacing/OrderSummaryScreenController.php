<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\Contract\Access\AccessDecisionCode;
use App\Interfacing\ServiceInterface\Interfacing\Access\AccessResolverInterface;
use App\Interfacing\ServiceInterface\Interfacing\Context\RequestBaseContextProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\Service\Interfacing\Crud\CrudRouteContextResolver;
use App\Interfacing\Service\Interfacing\Crud\CrudWorkbenchFactory;
use App\Interfacing\Service\Interfacing\Crud\CrudScreenContextResolver;
use App\Interfacing\ServiceInterface\Interfacing\Query\OrderSummaryQueryServiceInterface;
use App\Interfacing\ServiceInterface\Support\Audit\AuditSinkInterface;
use App\Interfacing\Support\Audit\AuditEvent;
use App\Interfacing\Support\Audit\AuditEventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class OrderSummaryScreenController extends AbstractController
{
    private const ScreenId = 'order-summary';

    /**
     * @param \App\Interfacing\ServiceInterface\Interfacing\Context\RequestBaseContextProviderInterface $baseContext
     */
    public function __construct(
        private readonly ?TokenStorageInterface $tokenStorage = null,
        private readonly RequestBaseContextProviderInterface $baseContext,
        private readonly AccessResolverInterface $access,
        private readonly OrderSummaryQueryServiceInterface $orders,
        private readonly CrudRouteContextResolver $routeContextResolver,
        private readonly CrudWorkbenchFactory $workbenchFactory,
        private readonly CrudScreenContextResolver $screenContextResolver,
        private readonly AuditSinkInterface $audit,
        private readonly InterfacingRendererInterface $renderer,
    ) {
    }

    #[Route(path: '/interfacing/order/summary', name: 'interfacing_order_summary', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $token = $this->tokenStorage?->getToken();
        $ctx = $this->baseContext->provide($request, $token);

        $tenantId = (string) ($ctx['tenantId'] ?? 'default');
        $userId = isset($ctx['userId']) ? (string) $ctx['userId'] : null;

        $decision = $this->access->canOpenScreen(self::ScreenId, $request, $token);
        if (AccessDecisionCode::Allow !== $decision->code) {
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

        $this->audit->record(AuditEvent::now(
            AuditEventType::ScreenOpen,
            $tenantId,
            $userId,
            self::ScreenId,
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

        return $this->renderer->render('interfacing/order/summary.html.twig', [
            'screenId' => self::ScreenId,
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
