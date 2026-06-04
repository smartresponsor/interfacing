<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterfaceController extends AbstractController
{
    public function __construct(
        private readonly InterfaceRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing', name: 'interfacing_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->renderer->render('interface/home.html.twig', [
            'title' => 'Interfacing',
            'screenId' => 'workspace.home',
            'page' => [
                'title' => 'Interfacing workspace',
                'description' => 'Canonical shell entry for components, screens, and routing surfaces.',
            ],
        ]);
    }

    #[Route('/interfacing/page/index', name: 'interfacing_page_index', methods: ['GET'])]
    public function pageIndex(): Response
    {
        return $this->renderPage('page/index.html.twig', 'workspace.home');
    }

    #[Route('/interfacing/launchpad', name: 'interfacing_admin_launchpad', methods: ['GET'])]
    public function adminLaunchpad(): Response
    {
        return $this->renderPage('page/admin_launchpad.html.twig', 'admin.launchpad');
    }

    #[Route('/interfacing/readiness', name: 'interfacing_crud_readiness', methods: ['GET'])]
    public function crudReadiness(): Response
    {
        return $this->renderPage('page/crud_readiness.html.twig', 'crud.readiness');
    }

    #[Route('/interfacing/tables', name: 'interfacing_admin_tables', methods: ['GET'])]
    public function adminTables(): Response
    {
        return $this->renderPage('page/admin_tables.html.twig', 'admin.tables');
    }

    #[Route('/interfacing/affordances', name: 'interfacing_crud_affordances', methods: ['GET'])]
    public function crudAffordances(): Response
    {
        return $this->renderPage('page/crud_affordances.html.twig', 'crud.affordances');
    }

    #[Route('/interfacing/forms', name: 'interfacing_crud_frames', methods: ['GET'])]
    public function crudFrames(): Response
    {
        return $this->renderPage('page/crud_frames.html.twig', 'crud.frames');
    }

    #[Route('/interfacing/screens', name: 'interfacing_screen_directory', methods: ['GET'])]
    public function screenDirectory(): Response
    {
        return $this->renderPage('page/screen_directory.html.twig', 'screen.directory');
    }

    #[Route('/interfacing/operations', name: 'interfacing_operation_workbench', methods: ['GET'])]
    public function operationWorkbench(): Response
    {
        return $this->renderPage('page/operation_workbench.html.twig', 'operation.workbench');
    }

    #[Route('/interfacing/surface', name: 'interfacing_surface_audit', methods: ['GET'])]
    public function surfaceAudit(): Response
    {
        return $this->renderPage('page/surface_audit.html.twig', 'surface.audit');
    }

    #[Route('/interfacing/components', name: 'interfacing_component_roadmap', methods: ['GET'])]
    public function componentRoadmap(): Response
    {
        return $this->renderPage('page/component_roadmap.html.twig', 'component.roadmap');
    }

    #[Route('/interfacing/obligations', name: 'interfacing_component_obligations', methods: ['GET'])]
    public function componentObligations(): Response
    {
        return $this->renderPage('page/component_obligations.html.twig', 'component.obligations');
    }

    #[Route('/interfacing/runtime-handoff', name: 'interfacing_runtime_handoff', methods: ['GET'])]
    public function runtimeHandoff(): Response
    {
        return $this->renderPage('page/runtime_handoff.html.twig', 'runtime.handoff');
    }

    #[Route('/interfacing/evidence', name: 'interfacing_evidence_registry', methods: ['GET'])]
    public function evidenceRegistry(): Response
    {
        return $this->renderPage('page/evidence_registry.html.twig', 'evidence.registry');
    }

    #[Route('/interfacing/contracts', name: 'interfacing_contract_registry', methods: ['GET'])]
    public function contractRegistry(): Response
    {
        return $this->renderPage('page/contract_registry.html.twig', 'contract.registry');
    }

    #[Route('/interfacing/schemas', name: 'interfacing_field_schema_registry', methods: ['GET'])]
    public function fieldSchemaRegistry(): Response
    {
        return $this->renderPage('page/field_schema_registry.html.twig', 'field.schema.registry');
    }

    #[Route('/interfacing/promotions', name: 'interfacing_promotion_gates', methods: ['GET'])]
    public function promotionGates(): Response
    {
        return $this->renderPage('page/promotion_gates.html.twig', 'promotion.gates');
    }

    private function renderPage(string $template, string $screenId, array $context = []): Response
    {
        $context['screenId'] = $screenId;

        return $this->renderer->render($template, $context);
    }
}
