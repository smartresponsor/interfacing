# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
param(
  [string]$Root = (Resolve-Path ".").Path
)

$ErrorActionPreference = "Stop"

$required = @(
  "src/Domain/Interfacing/Query/BillingMeterRow.php",
  "src/Domain/Interfacing/Query/BillingMeterPage.php",
  "src/Domain/Interfacing/Query/OrderSummaryRow.php",
  "src/Domain/Interfacing/Query/OrderSummaryPage.php",
  "src/Service/Interfacing/Query/HttpBillingMeterQueryService.php",
  "src/Service/Interfacing/Query/HttpOrderSummaryQueryService.php",
  "config/services/interfacing_billing_order.yaml"
)

foreach ($rel in $required) {
  $p = Join-Path $Root $rel
  if (-not (Test-Path $p)) { throw "Missing file: $rel" }
}

Write-Host "Interfacing Stab-2 smoke: required files present."
