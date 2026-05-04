<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\View\InterfacingWorkspaceViewBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterfacingController extends AbstractController
{
    public function __construct(
        private readonly InterfacingRendererInterface $renderer,
        private readonly InterfacingWorkspaceViewBuilderInterface $workspaceView,
    ) {
    }

    #[Route('/interfacing', name: 'interfacing_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->renderPage('interfacing/page/index.html.twig', 'index');
    }

    #[Route('/interfacing/launchpad', name: 'interfacing_admin_launchpad', methods: ['GET'])]
    public function adminLaunchpad(): Response
    {
        return $this->renderPage('interfacing/page/admin_launchpad.html.twig', 'admin_launchpad');
    }

    #[Route('/interfacing/readiness', name: 'interfacing_crud_readiness', methods: ['GET'])]
    public function crudReadiness(): Response
    {
        return $this->renderPage('interfacing/page/crud_readiness.html.twig', 'crud_readiness');
    }

    #[Route('/interfacing/tables', name: 'interfacing_admin_tables', methods: ['GET'])]
    public function adminTables(): Response
    {
        return $this->renderPage('interfacing/page/admin_tables.html.twig', 'admin_tables');
    }

    #[Route('/interfacing/affordances', name: 'interfacing_crud_affordances', methods: ['GET'])]
    public function crudAffordances(): Response
    {
        return $this->renderPage('interfacing/page/crud_affordances.html.twig', 'crud_affordances');
    }

    #[Route('/interfacing/forms', name: 'interfacing_crud_frames', methods: ['GET'])]
    public function crudFrames(): Response
    {
        return $this->renderPage('interfacing/page/crud_frames.html.twig', 'crud_frames');
    }

    #[Route('/interfacing/screens', name: 'interfacing_screen_directory', methods: ['GET'])]
    public function screenDirectory(): Response
    {
        return $this->renderPage('interfacing/page/screen_directory.html.twig', 'screen_directory');
    }

    #[Route('/interfacing/operations', name: 'interfacing_operation_workbench', methods: ['GET'])]
    public function operationWorkbench(): Response
    {
        return $this->renderPage('interfacing/page/operation_workbench.html.twig', 'operation_workbench');
    }

    #[Route('/interfacing/surface', name: 'interfacing_surface_audit', methods: ['GET'])]
    public function surfaceAudit(): Response
    {
        return $this->renderPage('interfacing/page/surface_audit.html.twig', 'surface_audit');
    }

    #[Route('/interfacing/components', name: 'interfacing_component_roadmap', methods: ['GET'])]
    public function componentRoadmap(): Response
    {
        return $this->renderPage('interfacing/page/component_roadmap.html.twig', 'component_roadmap');
    }

    #[Route('/interfacing/obligations', name: 'interfacing_component_obligations', methods: ['GET'])]
    public function componentObligations(): Response
    {
        return $this->renderPage('interfacing/page/component_obligations.html.twig', 'component_obligations');
    }

    #[Route('/interfacing/bridges', name: 'interfacing_runtime_bridges', methods: ['GET'])]
    public function runtimeBridges(): Response
    {
        return $this->renderPage('interfacing/page/runtime_bridges.html.twig', 'runtime_bridges');
    }

    #[Route('/interfacing/evidence', name: 'interfacing_evidence_registry', methods: ['GET'])]
    public function evidenceRegistry(): Response
    {
        return $this->renderPage('interfacing/page/evidence_registry.html.twig', 'evidence_registry');
    }

    #[Route('/interfacing/contracts', name: 'interfacing_contract_registry', methods: ['GET'])]
    public function contractRegistry(): Response
    {
        return $this->renderPage('interfacing/page/contract_registry.html.twig', 'contract_registry');
    }

    #[Route('/interfacing/schemas', name: 'interfacing_field_schema_registry', methods: ['GET'])]
    public function fieldSchemaRegistry(): Response
    {
        return $this->renderPage('interfacing/page/field_schema_registry.html.twig', 'field_schema_registry');
    }

    #[Route('/interfacing/promotions', name: 'interfacing_promotion_gates', methods: ['GET'])]
    public function promotionGates(): Response
    {
        return $this->renderPage('interfacing/page/promotion_gates.html.twig', 'promotion_gates');
    }

    private function renderPage(string $template, string $page): Response
    {
        return $this->renderer->render($template, $this->workspaceView->build($page));
    }

}
