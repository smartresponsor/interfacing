param(
    [Parameter(Mandatory = $false)][string]$Path = ".",
    [Parameter(Mandatory = $false)][switch]$Quality
)

$ErrorActionPreference = "Stop"

$repoRoot = (Resolve-Path -LiteralPath $Path).Path
$gateSh = Join-Path $repoRoot ".gate/gate.sh"

$bash = Get-Command bash -ErrorAction SilentlyContinue
if ($null -eq $bash) {
    throw "bash not found. Install Git Bash or provide a native gate.ps1 implementation."
}

# Use bash gate as single source of truth (policy->proposal generation lives in gate.sh)
& bash $gateSh $repoRoot
exit $LASTEXITCODE
