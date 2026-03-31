<# 
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
#>
Param(
  [string]$Root = "."
)

$ErrorActionPreference = "Stop"

Write-Host "Interfacing apply: validating repository root..."

if (!(Test-Path (Join-Path $Root "composer.json"))) {
  Write-Host "composer.json not found. Run from repo root." -ForegroundColor Red
  exit 2
}

Write-Host "OK. This sketch is an overlay. Extract ZIP into repo root and commit."
