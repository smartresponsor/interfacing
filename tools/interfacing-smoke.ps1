# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
param(
  [string]$Root = (Resolve-Path ".").Path
)

$ErrorActionPreference = "Stop"

$required = @(
  "src/Service/Interfacing/Tenant/DefaultTenantResolver.php",
  "src/Service/Interfacing/Security/InterfacingPermissionNamer.php",
  "src/Infra/Interfacing/Security/InterfacingPermissionVoter.php",
  "src/Infra/Interfacing/Http/InterfacingDoctorController.php",
  "config/services/interfacing.yaml",
  "templates/interfacing/doctor/index.html.twig"
)

foreach ($rel in $required) {
  $p = Join-Path $Root $rel
  if (-not (Test-Path $p)) { throw "Missing file: $rel" }
}

Write-Host "Interfacing smoke: required files present."
