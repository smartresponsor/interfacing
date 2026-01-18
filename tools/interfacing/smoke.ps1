$ErrorActionPreference = "Stop"

php -v | Out-Null

if (Test-Path "bin/console") {
  php bin/console cache:warmup | Out-Null
  php bin/console interfacing:doctor | Out-Null
  Write-Host "Smoke: ok"
  exit 0
}

if (-not (Test-Path "config/routes/interfacing.yaml")) { throw "Missing config/routes/interfacing.yaml" }

Write-Host "Smoke: ok (static)"
