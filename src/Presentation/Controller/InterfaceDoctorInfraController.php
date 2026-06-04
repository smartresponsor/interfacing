<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\Contract\Audit\InterfaceAuditEvent;
use App\Interfacing\Contract\Audit\InterfaceAuditEventType;
use App\Interfacing\NamerInterface\Security\InterfacePermissionNamerInterface;
use App\Interfacing\ProviderInterface\Context\InterfaceRequestBaseContextProviderInterface;
use App\Interfacing\ResolverInterface\Access\InterfaceScreenActionAccessResolverInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use App\Interfacing\SinkInterface\Audit\InterfaceAuditSinkInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class InterfaceDoctorInfraController extends AbstractController
{
    public function __construct(
        private readonly ?TokenStorageInterface $tokenStorage,
        private readonly InterfaceRequestBaseContextProviderInterface $baseContext,
        private readonly InterfaceScreenActionAccessResolverInterface $access,
        private readonly InterfacePermissionNamerInterface $permission,
        private readonly InterfaceAuditSinkInterface $audit,
        private readonly InterfaceRendererInterface $renderer,
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

        $this->audit->record(InterfaceAuditEvent::now(
            InterfaceAuditEventType::ScreenOpen,
            (string) ($ctx['tenantId'] ?? 'default'),
            isset($ctx['userId']) ? (string) $ctx['userId'] : null,
            'interfacing-doctor',
            null,
            [
                'path' => $request->getPathInfo(),
                'ip' => (string) $request->getClientIp(),
            ],
        ));

        return $this->renderer->render('doctor/index.html.twig', [
            'title' => 'Doctor infra',
            'screenId' => 'interfacing.doctor.infra',
            'ctx' => $ctx,
            'screenCheck' => $screenCheck,
        ]);
    }
}
