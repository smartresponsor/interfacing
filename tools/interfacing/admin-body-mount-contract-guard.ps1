param(
    [string]$ProjectRoot = (Resolve-Path (Join-Path $PSScriptRoot '..\..')).Path
)

$ErrorActionPreference = 'Stop'
$guard = Join-Path $ProjectRoot 'tools\interfacing\admin-body-mount-contract-guard.php'
php $guard
