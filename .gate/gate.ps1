param(
    [Parameter(Mandatory = $false)]
    [Alias('Path', 'Root', 'Target')]
    [string]$RepoRoot = (Get-Location).Path,

    [Parameter(Mandatory = $false)]
    [switch]$Quality
)

$ErrorActionPreference = "Stop"

$mode = "consumer"
if ($env:GITHUB_REPOSITORY -match "/canonization$")
{
    $mode = "canon"
}

Write-Host "[gate] repo=$env:GITHUB_REPOSITORY mode=$mode root=$RepoRoot"

# Contract (repo invariants)
# root-contract => ONLY for canonization repo
if ($mode -eq "canon")
{
    & (Join-Path $RepoRoot ".gate/contract/ps1/root-contract-check.ps1") -RepoRoot $RepoRoot
}
else
{
    Write-Host "[gate] skip root-contract-check (consumer repo)"
}

# gitignore template check => OK for everyone
& (Join-Path $RepoRoot ".gate/contract/ps1/gitignore-template-check.ps1") -RepoRoot $RepoRoot

# Linting (fast checks)
# JS checks require node
$node = Get-Command node -ErrorAction SilentlyContinue
if ($null -ne $node)
{
    node (Join-Path $RepoRoot ".gate/linting/js/no-plural-check.js") $RepoRoot
    node (Join-Path $RepoRoot ".gate/linting/js/layer-mirror-check.js") $RepoRoot
    node (Join-Path $RepoRoot ".gate/linting/js/doc-name-check.js") $RepoRoot
    node (Join-Path $RepoRoot ".gate/linting/js/archive-name-check.js") $RepoRoot
}
else
{
    Write-Host "node not found, skipping JS linting checks"
}

& (Join-Path $RepoRoot ".gate/linting/ps1/copyright-header-check.ps1") -RepoRoot $RepoRoot
& (Join-Path $RepoRoot ".gate/linting/ps1/layer-mirror-check.ps1") -RepoRoot $RepoRoot
& (Join-Path $RepoRoot ".gate/linting/ps1/doc-name-check.ps1") -RepoRoot $RepoRoot
& (Join-Path $RepoRoot ".gate/linting/ps1/archive-flat-root-check.ps1") -RepoRoot $RepoRoot

if ($Quality)
{
    & (Join-Path $RepoRoot ".gate/quality/ps1/quality-run.ps1") -RepoRoot $RepoRoot
}

Write-Host "Gate OK"
