param(
    [string]$ProjectRoot = (Resolve-Path (Join-Path $PSScriptRoot '..\..')).Path
)

$ErrorActionPreference = 'Stop'
Push-Location $ProjectRoot
try {
    php tools/interfacing/admin-body-visible-page-provider-migration-guard.php
} finally {
    Pop-Location
}
