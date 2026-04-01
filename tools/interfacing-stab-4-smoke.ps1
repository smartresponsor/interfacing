# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
param(
  [string]$Root = (Resolve-Path ".").Path
)

$ErrorActionPreference = "Stop"

$required = @(
  "src/Infra/Interfacing/Console/InterfacingScreenDumpCommand.php",
  "src/Infra/Interfacing/Console/InterfacingScreenValidateCommand.php",
  "config/services/interfacing_stab4_console.yaml",
  "tests/Interfacing/Query/HttpBillingMeterQueryServiceTest.php",
  "tests/Interfacing/Query/HttpOrderSummaryQueryServiceTest.php"
)

foreach ($rel in $required) {
  $p = Join-Path $Root $rel
  if (-not (Test-Path $p)) { throw "Missing file: $rel" }
}

Write-Host "Interfacing Stab-4 smoke: DX commands and HTTP binding tests present."
