# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
param(
  [string]$Root = (Resolve-Path ".").Path
)

$ErrorActionPreference = "Stop"

$required = @(
  "src/Infra/Interfacing/Http/BillingMeterScreenController.php",
  "src/Infra/Interfacing/Http/OrderSummaryScreenController.php",
  "templates/interfacing/billing/meter.html.twig",
  "templates/interfacing/order/summary.html.twig"
)

foreach ($rel in $required) {
  $p = Join-Path $Root $rel
  if (-not (Test-Path $p)) { throw "Missing file: $rel" }
}

Write-Host "Interfacing Stab-3 smoke: required files present."
