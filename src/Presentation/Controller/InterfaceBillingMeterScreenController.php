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
use App\Interfacing\ServiceInterface\Query\InterfaceBillingMeterQueryServiceInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use App\Interfacing\SinkInterface\Audit\InterfaceAuditSinkInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class InterfaceBillingMeterScreenController extends AbstractController
{
    private const InterfaceScreenId = 'billing-meter';

    public function __construct(
        private readonly InterfaceRequestBaseContextProviderInterface $baseContext,
        private readonly InterfaceScreenActionAccessResolverInterface $access,
        private readonly InterfaceBillingMeterQueryServiceInterface $billing,
        private readonly InterfaceCrudRouteContextResolver $routeContextResolver,
        private readonly InterfaceCrudWorkbenchFactory $workbenchFactory,
        private readonly InterfaceCrudScreenContextResolver $screenContextResolver,
        private readonly InterfaceAuditSinkInterface $audit,
        private readonly InterfaceRendererInterface $renderer,
        private readonly ?TokenStorageInterface $tokenStorage = null,
    ) {
    }

    #[Route(path: '/interfacing/billing/meter', name: 'interfacing_billing_meter', methods: ['GET'])]
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
        $periodFrom = (string) $request->query->get('periodFrom', '');
        $periodTo = (string) $request->query->get('periodTo', '');

        $statusFilter = '' !== $status ? $status : null;
        $periodFromFilter = '' !== $periodFrom ? $periodFrom : null;
        $periodToFilter = '' !== $periodTo ? $periodTo : null;

        $pageData = $this->billing->fetchPage(
            $tenantId,
            $page,
            $pageSize,
            $statusFilter,
            $periodFromFilter,
            $periodToFilter,
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
                'periodFrom' => $periodFromFilter,
                'periodTo' => $periodToFilter,
            ],
        ));

        $filters = [
            'status' => $status,
            'periodFrom' => $periodFrom,
            'periodTo' => $periodTo,
        ];

        $routeContext = $this->routeContextResolver->resolve($request, 'billing/meter');
        $screenContext = $this->screenContextResolver->resolve($request, $routeContext);

        return $this->renderer->render('billing/meter.html.twig', [
            'screenId' => self::InterfaceScreenId,
            'ctx' => $ctx,
            'workbench' => $this->workbenchFactory->buildBillingMeterView(
                $pageData,
                $filters,
                $ctx,
                $routeContext,
                $screenContext,
            ),
        ]);
    }
}
