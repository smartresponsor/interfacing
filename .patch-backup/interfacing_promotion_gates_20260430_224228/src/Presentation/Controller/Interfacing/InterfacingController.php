<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\Controller\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceAdminTableProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceCrudAffordanceProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceComponentObligationProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceComponentRoadmapProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceCrudFrameProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceCrudReadinessProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceOperationWorkbenchProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceRuntimeBridgeProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceScreenCatalogProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;
use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenContextAssemblerInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\AccessResolverInterface;
use App\Interfacing\ServiceInterface\Interfacing\Surface\InterfaceSurfaceAuditProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InterfacingController extends AbstractController
{
    public function __construct(
        private readonly LayoutCatalogInterface $layout,
        private readonly ScreenRegistryInterface $screen,
        private readonly ScreenContextAssemblerInterface $context,
        private readonly AccessResolverInterface $access,
        private readonly InterfacingRendererInterface $renderer,
        private readonly EcommerceScreenCatalogProviderInterface $ecommerceScreenCatalogProvider,
        private readonly EcommerceOperationWorkbenchProviderInterface $ecommerceOperationWorkbenchProvider,
        private readonly EcommerceAdminTableProviderInterface $ecommerceAdminTableProvider,
        private readonly EcommerceCrudAffordanceProviderInterface $ecommerceCrudAffordanceProvider,
        private readonly EcommerceCrudFrameProviderInterface $ecommerceCrudFrameProvider,
        private readonly EcommerceCrudReadinessProviderInterface $ecommerceCrudReadinessProvider,
        private readonly EcommerceComponentRoadmapProviderInterface $ecommerceComponentRoadmapProvider,
        private readonly EcommerceComponentObligationProviderInterface $ecommerceComponentObligationProvider,
        private readonly EcommerceRuntimeBridgeProviderInterface $ecommerceRuntimeBridgeProvider,
        private readonly InterfaceSurfaceAuditProviderInterface $interfaceSurfaceAuditProvider,
    ) {
    }

    #[Route('/interfacing', name: 'interfacing_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->renderer->render('interfacing/page/index.html.twig', [
            'title' => 'Interfacing workspace',
            'screenId' => 'interfacing.index',
            'ecommerceScreenMatrix' => $this->ecommerceScreenCatalogProvider->provide(),
            'ecommerceScreenGroups' => $this->ecommerceScreenCatalogProvider->groupedByZone(),
            'ecommerceScreenStatusCounts' => $this->ecommerceScreenCatalogProvider->statusCounts(),
            'operationStatusCounts' => $this->ecommerceOperationWorkbenchProvider->statusCounts(),
            'adminTableStatusCounts' => $this->ecommerceAdminTableProvider->statusCounts(),
            'crudAffordanceStatusCounts' => $this->ecommerceCrudAffordanceProvider->statusCounts(),
            'componentRoadmapStatusCounts' => $this->ecommerceComponentRoadmapProvider->statusCounts(),
            'componentObligationRiskCounts' => $this->ecommerceComponentObligationProvider->riskCounts(),
            'runtimeBridgeGradeCounts' => $this->ecommerceRuntimeBridgeProvider->gradeCounts(),
            'crudReadinessGradeCounts' => $this->ecommerceCrudReadinessProvider->gradeCounts(),
        ]);
    }


    #[Route('/interfacing/launchpad', name: 'interfacing_admin_launchpad', methods: ['GET'])]
    public function adminLaunchpad(): Response
    {
        return $this->renderer->render('interfacing/page/admin_launchpad.html.twig', [
            'title' => 'Interfacing admin launchpad',
            'screenId' => 'admin.launchpad',
            'operationGroups' => $this->ecommerceOperationWorkbenchProvider->groupedByZone(),
            'operationStatusCounts' => $this->ecommerceOperationWorkbenchProvider->statusCounts(),
            'componentRoadmapGroups' => $this->ecommerceComponentRoadmapProvider->groupedByZone(),
            'componentRoadmapStatusCounts' => $this->ecommerceComponentRoadmapProvider->statusCounts(),
            'ecommerceScreenStatusCounts' => $this->ecommerceScreenCatalogProvider->statusCounts(),
            'adminTableStatusCounts' => $this->ecommerceAdminTableProvider->statusCounts(),
        ]);
    }

    #[Route('/interfacing/readiness', name: 'interfacing_crud_readiness', methods: ['GET'])]
    public function crudReadiness(): Response
    {
        return $this->renderer->render('interfacing/page/crud_readiness.html.twig', [
            'title' => 'Interfacing CRUD readiness',
            'screenId' => 'crud.readiness',
            'crudReadinessGroups' => $this->ecommerceCrudReadinessProvider->groupedByZone(),
            'crudReadinessGradeCounts' => $this->ecommerceCrudReadinessProvider->gradeCounts(),
            'adminTableStatusCounts' => $this->ecommerceAdminTableProvider->statusCounts(),
            'crudAffordanceStatusCounts' => $this->ecommerceCrudAffordanceProvider->statusCounts(),
        ]);
    }

    #[Route('/interfacing/tables', name: 'interfacing_admin_tables', methods: ['GET'])]
    public function adminTables(): Response
    {
        return $this->renderer->render('interfacing/page/admin_tables.html.twig', [
            'title' => 'Interfacing admin tables',
            'screenId' => 'admin.tables',
            'adminTableRows' => $this->ecommerceAdminTableProvider->provide(),
            'adminTableGroups' => $this->ecommerceAdminTableProvider->groupedByZone(),
            'adminTableStatusCounts' => $this->ecommerceAdminTableProvider->statusCounts(),
            'crudAffordanceStatusCounts' => $this->ecommerceCrudAffordanceProvider->statusCounts(),
        ]);
    }

    #[Route('/interfacing/affordances', name: 'interfacing_crud_affordances', methods: ['GET'])]
    public function crudAffordances(): Response
    {
        return $this->renderer->render('interfacing/page/crud_affordances.html.twig', [
            'title' => 'Interfacing CRUD affordances',
            'screenId' => 'crud.affordances',
            'crudAffordanceGroups' => $this->ecommerceCrudAffordanceProvider->groupedByZone(),
            'crudAffordanceStatusCounts' => $this->ecommerceCrudAffordanceProvider->statusCounts(),
            'adminTableStatusCounts' => $this->ecommerceAdminTableProvider->statusCounts(),
        ]);
    }

    #[Route('/interfacing/forms', name: 'interfacing_crud_frames', methods: ['GET'])]
    public function crudFrames(): Response
    {
        return $this->renderer->render('interfacing/page/crud_frames.html.twig', [
            'title' => 'Interfacing CRUD form frames',
            'screenId' => 'crud.frames',
            'crudFrameGroups' => $this->ecommerceCrudFrameProvider->groupedByZone(),
            'crudFrameStatusCounts' => $this->ecommerceCrudFrameProvider->statusCounts(),
            'adminTableStatusCounts' => $this->ecommerceAdminTableProvider->statusCounts(),
        ]);
    }

    #[Route('/interfacing/screens', name: 'interfacing_screen_directory', methods: ['GET'])]
    public function screenDirectory(): Response
    {
        return $this->renderer->render('interfacing/page/screen_directory.html.twig', [
            'title' => 'Interfacing screen directory',
            'screenId' => 'screen.directory',
            'ecommerceScreenMatrix' => $this->ecommerceScreenCatalogProvider->provide(),
            'ecommerceScreenGroups' => $this->ecommerceScreenCatalogProvider->groupedByZone(),
            'ecommerceScreenStatusCounts' => $this->ecommerceScreenCatalogProvider->statusCounts(),
            'ecommerceComponentGroups' => $this->ecommerceScreenCatalogProvider->componentSummaryByZone(),
        ]);
    }

    #[Route('/interfacing/operations', name: 'interfacing_operation_workbench', methods: ['GET'])]
    public function operationWorkbench(): Response
    {
        return $this->renderer->render('interfacing/page/operation_workbench.html.twig', [
            'title' => 'Interfacing operation workbench',
            'screenId' => 'operation.workbench',
            'operationCards' => $this->ecommerceOperationWorkbenchProvider->provide(),
            'operationGroups' => $this->ecommerceOperationWorkbenchProvider->groupedByZone(),
            'operationStatusCounts' => $this->ecommerceOperationWorkbenchProvider->statusCounts(),
            'componentRoadmapStatusCounts' => $this->ecommerceComponentRoadmapProvider->statusCounts(),
        ]);
    }

    #[Route('/interfacing/surface', name: 'interfacing_surface_audit', methods: ['GET'])]
    public function surfaceAudit(): Response
    {
        return $this->renderer->render('interfacing/page/surface_audit.html.twig', [
            'title' => 'Interfacing surface audit',
            'screenId' => 'surface.audit',
            'surfaceGroups' => $this->interfaceSurfaceAuditProvider->groupedByArea(),
            'surfaceStatusCounts' => $this->interfaceSurfaceAuditProvider->statusCounts(),
        ]);
    }

    #[Route('/interfacing/components', name: 'interfacing_component_roadmap', methods: ['GET'])]
    public function componentRoadmap(): Response
    {
        return $this->renderer->render('interfacing/page/component_roadmap.html.twig', [
            'title' => 'Interfacing component roadmap',
            'screenId' => 'component.roadmap',
            'componentRoadmapGroups' => $this->ecommerceComponentRoadmapProvider->groupedByZone(),
            'componentRoadmapStatusCounts' => $this->ecommerceComponentRoadmapProvider->statusCounts(),
        ]);
    }

    #[Route('/interfacing/obligations', name: 'interfacing_component_obligations', methods: ['GET'])]
    public function componentObligations(): Response
    {
        return $this->renderer->render('interfacing/page/component_obligations.html.twig', [
            'title' => 'Interfacing component obligations',
            'screenId' => 'component.obligations',
            'componentObligationGroups' => $this->ecommerceComponentObligationProvider->groupedByZone(),
            'componentObligationRiskCounts' => $this->ecommerceComponentObligationProvider->riskCounts(),
            'runtimeBridgeGradeCounts' => $this->ecommerceRuntimeBridgeProvider->gradeCounts(),
            'componentRoadmapStatusCounts' => $this->ecommerceComponentRoadmapProvider->statusCounts(),
        ]);
    }

    #[Route('/interfacing/bridges', name: 'interfacing_runtime_bridges', methods: ['GET'])]
    public function runtimeBridges(): Response
    {
        return $this->renderer->render('interfacing/page/runtime_bridges.html.twig', [
            'title' => 'Interfacing runtime bridges',
            'screenId' => 'runtime.bridges',
            'runtimeBridgeGroups' => $this->ecommerceRuntimeBridgeProvider->groupedByZone(),
            'runtimeBridgeGradeCounts' => $this->ecommerceRuntimeBridgeProvider->gradeCounts(),
            'componentObligationRiskCounts' => $this->ecommerceComponentObligationProvider->riskCounts(),
        ]);
    }

    #[Route('/interfacing/{id}', name: 'interfacing_screen', methods: ['GET'])]
    #[Route('/interfacing/screen/{id}', name: 'interfacing_screen_legacy', methods: ['GET'])]
    public function screen(string $id): Response
    {
        $spec = $this->layout->find($id);
        if (null === $spec) {
            throw $this->createNotFoundException('Unknown interfacing screen: '.$id);
        }

        $cap = $spec->guardKey();
        if (null !== $cap && !$this->access->allow($cap, ['layoutId' => $spec->id(), 'screenId' => $spec->screenId()->toString()])) {
            throw $this->createAccessDeniedException('Access denied for screen: '.$id);
        }

        $component = $this->screen->componentName($spec->screenId());
        $context = $this->context->contextFor($spec);

        return $this->renderer->render('interfacing/page/screen.html.twig', [
            'spec' => $spec,
            'component' => $component,
            'context' => $context,
            'title' => $spec->title(),
            'screenId' => $spec->id(),
        ]);
    }
}
