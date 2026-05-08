param(
    [string]$ProjectRoot = (Get-Location).Path
)

$ErrorActionPreference = 'Stop'
$GuardPath = Join-Path $ProjectRoot 'tools\interfacing\admin-body-ui-provider-canon-guard.php'

if (-not (Test-Path -LiteralPath $GuardPath)) {
    throw "Missing Interfacing admin body UI provider canon guard: $GuardPath"
}

Push-Location $ProjectRoot
try {
    php $GuardPath
}
finally {
    Pop-Location
}
