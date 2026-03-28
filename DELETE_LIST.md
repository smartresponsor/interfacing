# Wave 10 Delete List

Deleted moved donor files:
- src/Domain/Interfacing/Model/Form/FormFieldSpec.php
- src/Domain/Interfacing/Model/Form/FormSpec.php
- src/Domain/Interfacing/Model/Form/FormSubmitResult.php
- src/DomainInterface/Interfacing/Model/Form/FormFieldSpecInterface.php
- src/DomainInterface/Interfacing/Model/Form/FormSpecInterface.php
- src/DomainInterface/Interfacing/Model/Form/FormSubmitResultInterface.php
- src/Domain/Interfacing/Model/Metric/MetricCard.php
- src/Domain/Interfacing/Model/Metric/MetricDatum.php
- src/Domain/Interfacing/Model/Metric/MetricQuery.php
- src/Domain/Interfacing/Model/Metric/MetricSpec.php
- src/DomainInterface/Interfacing/Model/Metric/MetricCardInterface.php
- src/DomainInterface/Interfacing/Model/Metric/MetricDatumInterface.php
- src/DomainInterface/Interfacing/Model/Metric/MetricQueryInterface.php
- src/DomainInterface/Interfacing/Model/Metric/MetricSpecInterface.php
- src/Domain/Interfacing/Model/Wizard/WizardProgress.php
- src/Domain/Interfacing/Model/Wizard/WizardSpec.php
- src/Domain/Interfacing/Model/Wizard/WizardStepSpec.php
- src/DomainInterface/Interfacing/Model/Wizard/WizardProgressInterface.php
- src/DomainInterface/Interfacing/Model/Wizard/WizardSpecInterface.php
- src/DomainInterface/Interfacing/Model/Wizard/WizardStepSpecInterface.php
- src/Domain/Interfacing/Spec/FormFieldSpec.php
- src/Domain/Interfacing/Spec/FormSpec.php
- src/Domain/Interfacing/Spec/MetricSpec.php
- src/Domain/Interfacing/Spec/WizardStepSpec.php
- src/Domain/Interfacing/Spec/WizardSpec.php

# Wave 11 Delete List

Deleted moved donor files:
- src/Domain/Interfacing/Model/BulkAction/BulkActionResult.php
- src/Domain/Interfacing/Model/BulkAction/BulkActionSpec.php
- src/DomainInterface/Interfacing/Model/BulkAction/BulkActionResultInterface.php
- src/DomainInterface/Interfacing/Model/BulkAction/BulkActionSpecInterface.php
- src/Domain/Interfacing/Model/DataGrid/DataGridColumnSpec.php
- src/Domain/Interfacing/Model/DataGrid/DataGridQuery.php
- src/Domain/Interfacing/Model/DataGrid/DataGridResult.php
- src/Domain/Interfacing/Model/DataGrid/DataGridRow.php
- src/DomainInterface/Interfacing/Model/DataGrid/DataGridColumnSpecInterface.php
- src/DomainInterface/Interfacing/Model/DataGrid/DataGridQueryInterface.php
- src/DomainInterface/Interfacing/Model/DataGrid/DataGridResultInterface.php
- src/DomainInterface/Interfacing/Model/DataGrid/DataGridRowInterface.php
- src/Domain/Interfacing/Model/Shell/ShellNavGroup.php
- src/Domain/Interfacing/Model/Shell/ShellNavItem.php
- src/Domain/Interfacing/Model/Shell/ShellView.php
- src/DomainInterface/Interfacing/Model/Shell/ShellNavGroupInterface.php
- src/DomainInterface/Interfacing/Model/Shell/ShellNavItemInterface.php
- src/DomainInterface/Interfacing/Model/Shell/ShellViewInterface.php
- src/Domain/Interfacing/Query/BillingMeterPage.php
- src/Domain/Interfacing/Query/BillingMeterRow.php
- src/Domain/Interfacing/Query/OrderSummaryPage.php
- src/Domain/Interfacing/Query/OrderSummaryRow.php
- src/DomainInterface/Interfacing/Query/BillingMeterQueryInterface.php
- src/DomainInterface/Interfacing/Query/OrderSummaryQueryInterface.php

- src/Domain/Interfacing/Attribute/AsInterfacingAction.php
- src/Domain/Interfacing/Attribute/AsInterfacingScreen.php
- src/Domain/Interfacing/Demo/DemoUserProfileInput.php
- src/Domain/Interfacing/Model/CategoryFormModel.php
- src/Domain/Interfacing/Model/CategoryItemView.php
- src/Domain/Interfacing/Model/TelemetryEvent.php
- src/Domain/Interfacing/Model/UiState.php
- src/Domain/Interfacing/Model/WidgetId.php
- src/Domain/Interfacing/Action/ActionId.php
- src/DomainInterface/Interfacing/Model/UiStateInterface.php
- src/DomainInterface/Interfacing/Model/WidgetIdInterface.php

Wave 13 deleted donor files:
- src/Domain/Interfacing/Layout/LayoutId.php
- src/Domain/Interfacing/Layout/LayoutSpec.php
- src/Domain/Interfacing/Screen/ScreenId.php
- src/Domain/Interfacing/Screen/ScreenSpec.php
- src/Domain/Interfacing/Spec/LayoutScreenSpec.php
- src/DomainInterface/Interfacing/Layout/LayoutIdInterface.php
- src/DomainInterface/Interfacing/Layout/LayoutSpecInterface.php
- src/DomainInterface/Interfacing/Layout/LayoutProviderInterface.php
- src/DomainInterface/Interfacing/Screen/ScreenIdInterface.php
- src/DomainInterface/Interfacing/Screen/ScreenSpecInterface.php
- src/DomainInterface/Interfacing/Screen/ScreenProviderInterface.php
- src/DomainInterface/Interfacing/Value/ScreenIdInterface.php
- src/Service/Interfacing/Access/AllowAllAccessResolver.php

## Wave 14
- removed src/Domain and src/DomainInterface after final consumer cutover
- cut remaining action/context/security/telemetry consumer references to ServiceInterface/Contract layers
- switched old screen/nav/action paths to contract/runtime layers
