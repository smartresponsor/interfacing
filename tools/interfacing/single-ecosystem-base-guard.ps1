param(
    [string]$ProjectRoot = (Resolve-Path (Join-Path $PSScriptRoot '..\..')).Path
)

$ErrorActionPreference = 'Stop'
$guard = Join-Path $ProjectRoot 'tools\interfacing\single-ecosystem-base-guard.php'
php $guard
