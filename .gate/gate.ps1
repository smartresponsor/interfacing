param(
  [Parameter(Mandatory=$false)][string]$RepoRoot = (Get-Location).Path,
  [Parameter(Mandatory=$false)][switch]$Quality
)

$ErrorActionPreference = "Stop"

# Contract (repo invariants)
& (Join-Path $RepoRoot ".gate/contract/ps1/root-contract-check.ps1") -RepoRoot $RepoRoot
& (Join-Path $RepoRoot ".gate/contract/ps1/gitignore-template-check.ps1") -RepoRoot $RepoRoot

# Linting (fast checks)
# JS checks require node
$node = Get-Command node -ErrorAction SilentlyContinue
if ($null -ne $node) {
  node (Join-Path $RepoRoot ".gate/linting/js/no-plural-check.js") $RepoRoot
  node (Join-Path $RepoRoot ".gate/linting/js/layer-mirror-check.js") $RepoRoot
  node (Join-Path $RepoRoot ".gate/linting/js/doc-name-check.js") $RepoRoot
  node (Join-Path $RepoRoot ".gate/linting/js/archive-name-check.js") $RepoRoot
} else {
  Write-Host "node not found, skipping JS linting checks"
}

& (Join-Path $RepoRoot ".gate/linting/ps1/copyright-header-check.ps1") -RepoRoot $RepoRoot
& (Join-Path $RepoRoot ".gate/linting/ps1/layer-mirror-check.ps1") -RepoRoot $RepoRoot
& (Join-Path $RepoRoot ".gate/linting/ps1/doc-name-check.ps1") -RepoRoot $RepoRoot
& (Join-Path $RepoRoot ".gate/linting/ps1/archive-flat-root-check.ps1") -RepoRoot $RepoRoot

if ($Quality) {
  & (Join-Path $RepoRoot ".gate/quality/ps1/quality-run.ps1") -RepoRoot $RepoRoot
}

Write-Host "Gate OK"
