# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
# Proprietary and confidential.
param(
  [string]$Php = "php",
  [string]$Console = "bin/console"
)

Write-Host "Interfacing smoke: doctor" -ForegroundColor Cyan
& $Php $Console interfacing:doctor
if ($LASTEXITCODE -ne 0) { exit $LASTEXITCODE }

Write-Host "Interfacing smoke: route hint" -ForegroundColor Cyan
Write-Host "Open: http://localhost/interfacing?screen=demo.form"
