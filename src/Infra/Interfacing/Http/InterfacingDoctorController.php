<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Infra\Interfacing\Http;

use App\Domain\Interfacing\Audit\AuditEvent;
use App\Domain\Interfacing\Audit\AuditEventType;
use App\DomainInterface\Interfacing\Audit\AuditSinkInterface;
use App\DomainInterface\Interfacing\Context\BaseContextProviderInterface;
use App\DomainInterface\Interfacing\Security\PermissionNamerInterface;
use App\DomainInterface\Interfacing\Access\AccessResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class InterfacingDoctorController extends AbstractController
{
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly BaseContextProviderInterface $baseContext,
        private readonly AccessResolverInterface $access,
        private readonly PermissionNamerInterface $permission,
        private readonly AuditSinkInterface $audit,
    ) {}

    #[Route(path: '/interfacing/doctor/infra', name: 'interfacing_doctor_infra', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $token = $this->tokenStorage->getToken();
        $ctx = $this->baseContext->provide($request, $token);

        $screenSamples = [
            'category-admin',
            'billing-meter',
            'order-drill',
        ];

        $screenCheck = [];
        foreach ($screenSamples as $screenId) {
            $decision = $this->access->canOpenScreen($screenId, $request, $token);
            $screenCheck[] = [
                'screenId' => $screenId,
                'permission' => $this->permission->screen($screenId),
                'decision' => $decision->code->value,
                'reason' => $decision->reason,
            ];
        }

        $this->audit->record(AuditEvent::now(
            AuditEventType::ScreenOpen,
            (string) ($ctx['tenantId'] ?? 'default'),
            isset($ctx['userId']) ? (string) $ctx['userId'] : null,
            'interfacing-doctor',
            null,
            [
                'path' => $request->getPathInfo(),
                'ip' => (string) $request->getClientIp(),
            ],
        ));

        return $this->render('interfacing/doctor/index.html.twig', [
            'ctx' => $ctx,
            'screenCheck' => $screenCheck,
        ]);
    }
}
