param(
    [string]$ProjectRoot = (Get-Location).Path
)

$ErrorActionPreference = 'Stop'
$GuardPath = Join-Path $ProjectRoot 'tools\interfacing\admin-body-ecosystem-ui-coverage-audit.php'
php $GuardPath
