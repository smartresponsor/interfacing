<?php
declare(strict_types=1);

namespace App\Infra\Interfacing\Http;

use App\Domain\Interfacing\Access\AccessDecisionCode;
use App\Domain\Interfacing\Audit\AuditEvent;
use App\Domain\Interfacing\Audit\AuditEventType;
use App\DomainInterface\Interfacing\Access\AccessResolverInterface;
use App\DomainInterface\Interfacing\Audit\AuditSinkInterface;
use App\DomainInterface\Interfacing\Context\BaseContextProviderInterface;
use App\ServiceInterface\Interfacing\Query\OrderSummaryQueryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 *
 */

/**
 *
 */
final class OrderSummaryScreenController extends AbstractController
{
    private const ScreenId = 'order-summary';

    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage
     * @param \App\DomainInterface\Interfacing\Context\BaseContextProviderInterface $baseContext
     * @param \App\DomainInterface\Interfacing\Access\AccessResolverInterface $access
     * @param \App\ServiceInterface\Interfacing\Query\OrderSummaryQueryServiceInterface $orders
     * @param \App\DomainInterface\Interfacing\Audit\AuditSinkInterface $audit
     */
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly BaseContextProviderInterface $baseContext,
        private readonly AccessResolverInterface $access,
        private readonly OrderSummaryQueryServiceInterface $orders,
        private readonly AuditSinkInterface $audit,
    ) {}

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route(path: '/interfacing/order/summary', name: 'interfacing_order_summary', methods: ['GET'])]
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
        $createdFrom = (string) $request->query->get('createdFrom', '');
        $createdTo = (string) $request->query->get('createdTo', '');

        $statusFilter = $status !== '' ? $status : null;
        $createdFromFilter = $createdFrom !== '' ? $createdFrom : null;
        $createdToFilter = $createdTo !== '' ? $createdTo : null;

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

        return $this->render('interfacing/order/summary.html.twig', [
            'screenId' => self::ScreenId,
            'ctx' => $ctx,
            'page' => $pageData,
            'filters' => [
                'status' => $status,
                'createdFrom' => $createdFrom,
                'createdTo' => $createdTo,
            ],
        ]);
    }
}
