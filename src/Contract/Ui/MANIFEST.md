# Ui Manifest

UI contracts; route/screen/view-model/error semantics, aligned with docs/interfacing/ui-contract.yaml.
- AdminBodyRcReadinessContract.php
- AdminBodyUiProviderCanonContract.php
- AdminBodyStrictProviderRenderingContract.php
- AdminBodyConsumerProviderAdoptionContract.php
- AdminBodyConsumerProviderAdoptionRunnerContract.php
- AdminBodyEcommerceUiCoverageContract.php

- AdminBodyFrontendBuildHardeningContract.php
- AdminBodyVisiblePageProviderMigrationContract.php — Visible page provider migration contract.
- `AdminBodyConsumerProviderMigrationExecutorContract` — known consumer template migration executor contract for provider-owned UI adoption.

- Bridge provider surface: Bridge owns route/resource adoption; Interfacing renders provider-owned UI; direct consumer template rewrite is not the primary path.
- AdminBodyBridgeProviderSurfaceContract — bridge-owned route/resource provider surface.
