<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Access\AccessResolverInterface;
use App\Interfacing\ServiceInterface\Interfacing\Context\RequestBaseContextProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\Security\PermissionNamerInterface;
use App\Interfacing\ServiceInterface\Support\Audit\AuditSinkInterface;
use App\Interfacing\Support\Audit\AuditEvent;
use App\Interfacing\Support\Audit\AuditEventType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class InterfacingDoctorInfraController extends AbstractController
{
    public function __construct(
        private readonly ?TokenStorageInterface $tokenStorage,
        private readonly RequestBaseContextProviderInterface $baseContext,
        private readonly AccessResolverInterface $access,
        private readonly PermissionNamerInterface $permission,
        private readonly AuditSinkInterface $audit,
        private readonly InterfacingRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing/doctor/infra', name: 'interfacing_doctor_infra', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $token = $this->tokenStorage?->getToken();
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

        return $this->renderer->render('interfacing/doctor/index.html.twig', [
            'title' => 'Doctor infra',
            'screenId' => 'interfacing.doctor.infra',
            'ctx' => $ctx,
            'screenCheck' => $screenCheck,
        ]);
    }
}
