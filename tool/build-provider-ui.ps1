$ErrorActionPreference = 'Stop'

& npm.cmd run ui:build

if ($LASTEXITCODE -ne 0) {
    throw "Provider UI build failed with exit code $LASTEXITCODE."
}

Write-Output 'Provider UI built.'
