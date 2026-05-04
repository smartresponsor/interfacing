<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Interfacing\View;

use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceAdminTableProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceComponentObligationProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceComponentRoadmapProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceContractRegistryProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceCrudAffordanceProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceCrudFrameProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceCrudReadinessProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceEvidenceRegistryProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceFieldSchemaRegistryProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceOperationWorkbenchProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommercePromotionGateProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceRuntimeBridgeProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Ecommerce\EcommerceScreenCatalogProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Surface\InterfaceSurfaceAuditProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\View\InterfacingWorkspaceViewBuilderInterface;

final readonly class InterfacingWorkspaceViewBuilder implements InterfacingWorkspaceViewBuilderInterface
{
    public function __construct(
        private EcommerceScreenCatalogProviderInterface $screenCatalog,
        private EcommerceOperationWorkbenchProviderInterface $operationWorkbench,
        private EcommerceAdminTableProviderInterface $adminTable,
        private EcommerceCrudAffordanceProviderInterface $crudAffordance,
        private EcommerceCrudFrameProviderInterface $crudFrame,
        private EcommerceCrudReadinessProviderInterface $crudReadiness,
        private EcommerceComponentRoadmapProviderInterface $componentRoadmap,
        private EcommerceComponentObligationProviderInterface $componentObligation,
        private EcommerceRuntimeBridgeProviderInterface $runtimeBridge,
        private EcommercePromotionGateProviderInterface $promotionGate,
        private EcommerceEvidenceRegistryProviderInterface $evidenceRegistry,
        private EcommerceContractRegistryProviderInterface $contractRegistry,
        private EcommerceFieldSchemaRegistryProviderInterface $fieldSchemaRegistry,
        private InterfaceSurfaceAuditProviderInterface $surfaceAudit,
    ) {
    }

    /** @return array<string, mixed> */
    public function build(string $page): array
    {
        return match ($page) {
            'index' => $this->index(),
            'admin_launchpad' => $this->adminLaunchpad(),
            'crud_readiness' => $this->crudReadiness(),
            'admin_tables' => $this->adminTables(),
            'crud_affordances' => $this->crudAffordances(),
            'crud_frames' => $this->crudFrames(),
            'screen_directory' => $this->screenDirectory(),
            'operation_workbench' => $this->operationWorkbench(),
            'surface_audit' => $this->surfaceAudit(),
            'component_roadmap' => $this->componentRoadmap(),
            'component_obligations' => $this->componentObligations(),
            'runtime_bridges' => $this->runtimeBridges(),
            'evidence_registry' => $this->evidenceRegistry(),
            'contract_registry' => $this->contractRegistry(),
            'field_schema_registry' => $this->fieldSchemaRegistry(),
            'promotion_gates' => $this->promotionGates(),
            default => throw new \InvalidArgumentException('Unknown interfacing workspace page: '.$page),
        };
    }

    /** @return array<string, mixed> */
    private function index(): array
    {
        return [
            'title' => 'Interfacing workspace',
            'screenId' => 'interfacing.index',
            'ecommerceScreenMatrix' => $this->screenCatalog->provide(),
            'ecommerceScreenGroups' => $this->screenCatalog->groupedByZone(),
            'ecommerceComponentGroups' => $this->screenCatalog->componentSummaryByZone(),
            'ecommerceScreenStatusCounts' => $this->screenCatalog->statusCounts(),
            'operationStatusCounts' => $this->operationWorkbench->statusCounts(),
            'adminTableStatusCounts' => $this->adminTable->statusCounts(),
            'crudAffordanceStatusCounts' => $this->crudAffordance->statusCounts(),
            'componentRoadmapStatusCounts' => $this->componentRoadmap->statusCounts(),
            'componentObligationRiskCounts' => $this->componentObligation->riskCounts(),
            'runtimeBridgeGradeCounts' => $this->runtimeBridge->gradeCounts(),
            'promotionGateCounts' => $this->promotionGate->gateCounts(),
            'evidenceGradeCounts' => $this->evidenceRegistry->gradeCounts(),
            'contractGradeCounts' => $this->contractRegistry->gradeCounts(),
            'fieldSchemaGradeCounts' => $this->fieldSchemaRegistry->gradeCounts(),
            'crudReadinessGradeCounts' => $this->crudReadiness->gradeCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function adminLaunchpad(): array
    {
        return [
            'title' => 'Interfacing admin launchpad',
            'screenId' => 'admin.launchpad',
            'operationGroups' => $this->operationWorkbench->groupedByZone(),
            'operationStatusCounts' => $this->operationWorkbench->statusCounts(),
            'componentRoadmapGroups' => $this->componentRoadmap->groupedByZone(),
            'componentRoadmapStatusCounts' => $this->componentRoadmap->statusCounts(),
            'ecommerceScreenStatusCounts' => $this->screenCatalog->statusCounts(),
            'adminTableStatusCounts' => $this->adminTable->statusCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function crudReadiness(): array
    {
        return [
            'title' => 'Interfacing CRUD readiness',
            'screenId' => 'crud.readiness',
            'crudReadinessGroups' => $this->crudReadiness->groupedByZone(),
            'crudReadinessGradeCounts' => $this->crudReadiness->gradeCounts(),
            'adminTableStatusCounts' => $this->adminTable->statusCounts(),
            'crudAffordanceStatusCounts' => $this->crudAffordance->statusCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function adminTables(): array
    {
        return [
            'title' => 'Interfacing admin tables',
            'screenId' => 'admin.tables',
            'adminTableRows' => $this->adminTable->provide(),
            'adminTableGroups' => $this->adminTable->groupedByZone(),
            'adminTableStatusCounts' => $this->adminTable->statusCounts(),
            'crudAffordanceStatusCounts' => $this->crudAffordance->statusCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function crudAffordances(): array
    {
        return [
            'title' => 'Interfacing CRUD affordances',
            'screenId' => 'crud.affordances',
            'crudAffordanceGroups' => $this->crudAffordance->groupedByZone(),
            'crudAffordanceStatusCounts' => $this->crudAffordance->statusCounts(),
            'adminTableStatusCounts' => $this->adminTable->statusCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function crudFrames(): array
    {
        return [
            'title' => 'Interfacing CRUD form frames',
            'screenId' => 'crud.frames',
            'crudFrameGroups' => $this->crudFrame->groupedByZone(),
            'crudFrameStatusCounts' => $this->crudFrame->statusCounts(),
            'adminTableStatusCounts' => $this->adminTable->statusCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function screenDirectory(): array
    {
        return [
            'title' => 'Interfacing screen directory',
            'screenId' => 'screen.directory',
            'ecommerceScreenMatrix' => $this->screenCatalog->provide(),
            'ecommerceScreenGroups' => $this->screenCatalog->groupedByZone(),
            'ecommerceScreenStatusCounts' => $this->screenCatalog->statusCounts(),
            'ecommerceComponentGroups' => $this->screenCatalog->componentSummaryByZone(),
        ];
    }

    /** @return array<string, mixed> */
    private function operationWorkbench(): array
    {
        return [
            'title' => 'Interfacing operation workbench',
            'screenId' => 'operation.workbench',
            'operationCards' => $this->operationWorkbench->provide(),
            'operationGroups' => $this->operationWorkbench->groupedByZone(),
            'operationStatusCounts' => $this->operationWorkbench->statusCounts(),
            'componentRoadmapStatusCounts' => $this->componentRoadmap->statusCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function surfaceAudit(): array
    {
        return [
            'title' => 'Interfacing surface audit',
            'screenId' => 'surface.audit',
            'surfaceGroups' => $this->surfaceAudit->groupedByArea(),
            'surfaceStatusCounts' => $this->surfaceAudit->statusCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function componentRoadmap(): array
    {
        return [
            'title' => 'Interfacing component roadmap',
            'screenId' => 'component.roadmap',
            'componentRoadmapGroups' => $this->componentRoadmap->groupedByZone(),
            'componentRoadmapStatusCounts' => $this->componentRoadmap->statusCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function componentObligations(): array
    {
        return [
            'title' => 'Interfacing component obligations',
            'screenId' => 'component.obligations',
            'componentObligationGroups' => $this->componentObligation->groupedByZone(),
            'componentObligationRiskCounts' => $this->componentObligation->riskCounts(),
            'runtimeBridgeGradeCounts' => $this->runtimeBridge->gradeCounts(),
            'componentRoadmapStatusCounts' => $this->componentRoadmap->statusCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function runtimeBridges(): array
    {
        return [
            'title' => 'Interfacing runtime bridges',
            'screenId' => 'runtime.bridges',
            'runtimeBridgeGroups' => $this->runtimeBridge->groupedByZone(),
            'runtimeBridgeGradeCounts' => $this->runtimeBridge->gradeCounts(),
            'componentObligationRiskCounts' => $this->componentObligation->riskCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function evidenceRegistry(): array
    {
        return [
            'title' => 'Interfacing evidence registry',
            'screenId' => 'evidence.registry',
            'evidenceGroups' => $this->evidenceRegistry->groupedByZone(),
            'evidenceGradeCounts' => $this->evidenceRegistry->gradeCounts(),
            'promotionGateCounts' => $this->promotionGate->gateCounts(),
            'runtimeBridgeGradeCounts' => $this->runtimeBridge->gradeCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function contractRegistry(): array
    {
        return [
            'title' => 'Interfacing contract registry',
            'screenId' => 'contract.registry',
            'contractGroups' => $this->contractRegistry->groupedByZone(),
            'contractGradeCounts' => $this->contractRegistry->gradeCounts(),
            'evidenceGradeCounts' => $this->evidenceRegistry->gradeCounts(),
            'promotionGateCounts' => $this->promotionGate->gateCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function fieldSchemaRegistry(): array
    {
        return [
            'title' => 'Interfacing field schema registry',
            'screenId' => 'field.schema.registry',
            'fieldSchemaGroups' => $this->fieldSchemaRegistry->groupedByZone(),
            'fieldSchemaGradeCounts' => $this->fieldSchemaRegistry->gradeCounts(),
            'contractGradeCounts' => $this->contractRegistry->gradeCounts(),
            'crudReadinessGradeCounts' => $this->crudReadiness->gradeCounts(),
        ];
    }

    /** @return array<string, mixed> */
    private function promotionGates(): array
    {
        return [
            'title' => 'Interfacing promotion gates',
            'screenId' => 'promotion.gates',
            'promotionGateGroups' => $this->promotionGate->groupedByZone(),
            'promotionGateCounts' => $this->promotionGate->gateCounts(),
            'runtimeBridgeGradeCounts' => $this->runtimeBridge->gradeCounts(),
        ];
    }
}
