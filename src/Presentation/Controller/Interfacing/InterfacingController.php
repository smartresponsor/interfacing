<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterfacingController extends AbstractController
{
    public function __construct(
        private readonly InterfacingRendererInterface $renderer,
    ) {
    }

    #[Route('/interfacing', name: 'interfacing_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->renderer->render('interfacing/bridge/provider_surface.html.twig', [
            'screenId' => 'workspace.home',
            'bridgeComponent' => 'cataloging',
            'bridgeResource' => 'catalog',
            'bridgeOperation' => 'index',
            'bridgeSurface' => 'admin',
            'bridgeTitle' => 'E-commerce provider workbench',
            'bridgeRows' => [
                ['id' => 'catalog-home-1', 'title' => 'Provider-rendered catalog', 'sku' => 'CAT-HOME-001', 'category' => 'Catalog', 'inventory' => 'ready', 'status' => 'active', 'price' => '$149.00'],
                ['id' => 'catalog-home-2', 'title' => 'Provider-rendered product grid', 'sku' => 'CAT-HOME-002', 'category' => 'Products', 'inventory' => '84 in stock', 'status' => 'active', 'price' => '$249.00'],
                ['id' => 'catalog-home-3', 'title' => 'Provider-rendered vendor channel', 'sku' => 'VEN-HOME-001', 'category' => 'Vendors', 'inventory' => 'connected', 'status' => 'review', 'price' => '$399.00'],
            ],
            'bridgeColumns' => [
                ['key' => 'title', 'label' => 'Provider-rendered surface', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
                ['key' => 'sku', 'label' => 'Code', 'type' => 'text', 'isCode' => true, 'isStatus' => false],
                ['key' => 'category', 'label' => 'Area', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
                ['key' => 'inventory', 'label' => 'Runtime state', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
                ['key' => 'status', 'label' => 'Status', 'type' => 'text', 'isCode' => false, 'isStatus' => true],
                ['key' => 'price', 'label' => 'Commercial sample', 'type' => 'text', 'isCode' => false, 'isStatus' => false],
            ],
            'bridgeFilters' => [
                ['name' => 'q', 'label' => 'Search', 'type' => 'text', 'value' => null, 'placeholder' => 'Search provider-rendered e-commerce UI', 'options' => []],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'value' => null, 'placeholder' => 'Any status', 'options' => []],
            ],
            'bridgeFormFields' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'value' => null, 'placeholder' => null, 'helpText' => null, 'required' => true, 'validationState' => null, 'errorText' => null, 'options' => []],
                ['name' => 'slug', 'label' => 'Slug', 'type' => 'text', 'value' => null, 'placeholder' => null, 'helpText' => null, 'required' => false, 'validationState' => null, 'errorText' => null, 'options' => []],
                ['name' => 'status', 'label' => 'Status', 'type' => 'text', 'value' => null, 'placeholder' => null, 'helpText' => null, 'required' => false, 'validationState' => null, 'errorText' => null, 'options' => []],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => null, 'placeholder' => null, 'helpText' => null, 'required' => false, 'validationState' => null, 'errorText' => null, 'options' => []],
            ],
        ]);
    }

    #[Route('/interfacing/page/index', name: 'interfacing_page_index', methods: ['GET'])]
    public function pageIndex(): Response
    {
        return $this->renderPage('interfacing/page/index.html.twig', 'workspace.home');
    }

    #[Route('/interfacing/launchpad', name: 'interfacing_admin_launchpad', methods: ['GET'])]
    public function adminLaunchpad(): Response
    {
        return $this->renderPage('interfacing/page/admin_launchpad.html.twig', 'admin.launchpad');
    }

    #[Route('/interfacing/readiness', name: 'interfacing_crud_readiness', methods: ['GET'])]
    public function crudReadiness(): Response
    {
        return $this->renderPage('interfacing/page/crud_readiness.html.twig', 'crud.readiness');
    }

    #[Route('/interfacing/tables', name: 'interfacing_admin_tables', methods: ['GET'])]
    public function adminTables(): Response
    {
        return $this->renderPage('interfacing/page/admin_tables.html.twig', 'admin.tables');
    }

    #[Route('/interfacing/affordances', name: 'interfacing_crud_affordances', methods: ['GET'])]
    public function crudAffordances(): Response
    {
        return $this->renderPage('interfacing/page/crud_affordances.html.twig', 'crud.affordances');
    }

    #[Route('/interfacing/forms', name: 'interfacing_crud_frames', methods: ['GET'])]
    public function crudFrames(): Response
    {
        return $this->renderPage('interfacing/page/crud_frames.html.twig', 'crud.frames');
    }

    #[Route('/interfacing/screens', name: 'interfacing_screen_directory', methods: ['GET'])]
    public function screenDirectory(): Response
    {
        return $this->renderPage('interfacing/page/screen_directory.html.twig', 'screen.directory');
    }

    #[Route('/interfacing/operations', name: 'interfacing_operation_workbench', methods: ['GET'])]
    public function operationWorkbench(): Response
    {
        return $this->renderPage('interfacing/page/operation_workbench.html.twig', 'operation.workbench');
    }

    #[Route('/interfacing/surface', name: 'interfacing_surface_audit', methods: ['GET'])]
    public function surfaceAudit(): Response
    {
        return $this->renderPage('interfacing/page/surface_audit.html.twig', 'surface.audit');
    }

    #[Route('/interfacing/components', name: 'interfacing_component_roadmap', methods: ['GET'])]
    public function componentRoadmap(): Response
    {
        return $this->renderPage('interfacing/page/component_roadmap.html.twig', 'component.roadmap');
    }

    #[Route('/interfacing/obligations', name: 'interfacing_component_obligations', methods: ['GET'])]
    public function componentObligations(): Response
    {
        return $this->renderPage('interfacing/page/component_obligations.html.twig', 'component.obligations');
    }

    #[Route('/interfacing/bridges', name: 'interfacing_runtime_bridges', methods: ['GET'])]
    public function runtimeBridges(): Response
    {
        return $this->renderPage('interfacing/page/runtime_bridges.html.twig', 'runtime.bridges');
    }

    #[Route('/interfacing/evidence', name: 'interfacing_evidence_registry', methods: ['GET'])]
    public function evidenceRegistry(): Response
    {
        return $this->renderPage('interfacing/page/evidence_registry.html.twig', 'evidence.registry');
    }

    #[Route('/interfacing/contracts', name: 'interfacing_contract_registry', methods: ['GET'])]
    public function contractRegistry(): Response
    {
        return $this->renderPage('interfacing/page/contract_registry.html.twig', 'contract.registry');
    }

    #[Route('/interfacing/schemas', name: 'interfacing_field_schema_registry', methods: ['GET'])]
    public function fieldSchemaRegistry(): Response
    {
        return $this->renderPage('interfacing/page/field_schema_registry.html.twig', 'field.schema.registry');
    }

    #[Route('/interfacing/promotions', name: 'interfacing_promotion_gates', methods: ['GET'])]
    public function promotionGates(): Response
    {
        return $this->renderPage('interfacing/page/promotion_gates.html.twig', 'promotion.gates');
    }

    private function renderPage(string $template, string $screenId, array $context = []): Response
    {
        $context['screenId'] = $screenId;

        return $this->renderer->render($template, $context);
    }
}
