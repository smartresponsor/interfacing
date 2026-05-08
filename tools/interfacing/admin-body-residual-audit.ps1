param(
    [string] $ProjectRoot = (Resolve-Path (Join-Path $PSScriptRoot '..\..')).Path
)

$ErrorActionPreference = 'Stop'

$guard = Join-Path $ProjectRoot 'tools\interfacing\admin-body-residual-audit.php'
if (-not (Test-Path -LiteralPath $guard -PathType Leaf)) {
    throw "Missing Interfacing admin body residual audit: $guard"
}

& php $guard
if ($LASTEXITCODE -ne 0) {
    throw "Interfacing admin body residual audit failed with exit code $LASTEXITCODE"
}
