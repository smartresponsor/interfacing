<?php
declare(strict_types=1);

namespace App\Infra\Interfacing\Http;

use App\Domain\Interfacing\Access\AccessDecisionCode;
use App\Domain\Interfacing\Audit\AuditEvent;
use App\Domain\Interfacing\Audit\AuditEventType;
use App\DomainInterface\Interfacing\Access\AccessResolverInterface;
use App\DomainInterface\Interfacing\Audit\AuditSinkInterface;
use App\DomainInterface\Interfacing\Context\BaseContextProviderInterface;
use App\ServiceInterface\Interfacing\Query\BillingMeterQueryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class BillingMeterScreenController extends AbstractController
{
    private const ScreenId = 'billing-meter';

    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly BaseContextProviderInterface $baseContext,
        private readonly AccessResolverInterface $access,
        private readonly BillingMeterQueryServiceInterface $billing,
        private readonly AuditSinkInterface $audit,
    ) {}

    #[Route(path: '/interfacing/billing/meter', name: 'interfacing_billing_meter', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $token = $this->tokenStorage->getToken();
        $ctx = $this->baseContext->provide($request, $token);

        $tenantId = (string) ($ctx['tenantId'] ?? 'default');
        $userId = isset($ctx['userId']) ? (string) $ctx['userId'] : null;

        $decision = $this->access->canOpenScreen(self::ScreenId, $request, $token);
        if ($decision->code !== AccessDecisionCode::Allow) {
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

        $statusFilter = $status !== '' ? $status : null;
        $periodFromFilter = $periodFrom !== '' ? $periodFrom : null;
        $periodToFilter = $periodTo !== '' ? $periodTo : null;

        $pageData = $this->billing->fetchPage(
            $tenantId,
            $page,
            $pageSize,
            $statusFilter,
            $periodFromFilter,
            $periodToFilter,
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
                'periodFrom' => $periodFromFilter,
                'periodTo' => $periodToFilter,
            ],
        ));

        return $this->render('interfacing/billing/meter.html.twig', [
            'screenId' => self::ScreenId,
            'ctx' => $ctx,
            'page' => $pageData,
            'filters' => [
                'status' => $status,
                'periodFrom' => $periodFrom,
                'periodTo' => $periodTo,
            ],
        ]);
    }
}
