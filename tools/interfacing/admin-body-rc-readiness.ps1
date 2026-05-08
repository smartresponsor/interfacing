param(
    [string]$ProjectRoot = (Get-Location).Path
)

$ErrorActionPreference = 'Stop'
$GuardPath = Join-Path $ProjectRoot 'tools\interfacing\admin-body-rc-readiness.php'

if (-not (Test-Path -LiteralPath $GuardPath)) {
    throw "Missing Interfacing admin body RC readiness guard: $GuardPath"
}

Push-Location $ProjectRoot
try {
    php $GuardPath
}
finally {
    Pop-Location
}
