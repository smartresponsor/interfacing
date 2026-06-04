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

Provider handoff canon: owning components expose route/resource context; Interfacing renders a provider-native handoff schema and must not own component persistence, local tables, or root-level catch-all screens.
