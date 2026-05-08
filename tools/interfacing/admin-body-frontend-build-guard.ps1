param(
    [string] $ProjectRoot = (Get-Location).Path
)

Set-StrictMode -Version Latest
$ErrorActionPreference = 'Stop'

$projectFull = [System.IO.Path]::GetFullPath($ProjectRoot)
$guard = Join-Path $projectFull 'tools/interfacing/admin-body-frontend-build-guard.php'

if (-not (Test-Path -LiteralPath $guard)) {
    throw "Missing Interfacing frontend build guard: $guard"
}

Push-Location $projectFull
try {
    & php $guard
    if ($LASTEXITCODE -ne 0) {
        throw "Interfacing admin body frontend build guard failed with exit code $LASTEXITCODE"
    }
}
finally {
    Pop-Location
}
