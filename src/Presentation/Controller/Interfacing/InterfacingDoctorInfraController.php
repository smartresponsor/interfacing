<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Presentation\Controller\Interfacing;

use App\ServiceInterface\Interfacing\Access\AccessResolverInterface;
use App\ServiceInterface\Interfacing\Context\RequestBaseContextProviderInterface;
use App\ServiceInterface\Interfacing\Security\PermissionNamerInterface;
use App\ServiceInterface\Support\Audit\AuditSinkInterface;
use App\Support\Audit\AuditEvent;
use App\Support\Audit\AuditEventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final readonly class InterfacingDoctorInfraController extends AbstractController
{
    /**
     * @param \App\ServiceInterface\Interfacing\Context\RequestRequestBaseContextProviderInterface $baseContext
     */
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private RequestBaseContextProviderInterface $baseContext,
        private AccessResolverInterface $access,
        private PermissionNamerInterface $permission,
        private AuditSinkInterface $audit,
    ) {
    }

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
