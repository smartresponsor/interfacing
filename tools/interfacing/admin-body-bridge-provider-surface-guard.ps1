param(
    [string] $ProjectRoot = (Resolve-Path (Join-Path $PSScriptRoot '..\..')).Path,
    [string] $Php = 'php'
)

$ErrorActionPreference = 'Stop'
Push-Location $ProjectRoot
try {
    & $Php 'tools/interfacing/admin-body-bridge-provider-surface-guard.php'
    if ($LASTEXITCODE -ne 0) { exit $LASTEXITCODE }
} finally {
    Pop-Location
}
