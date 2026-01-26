param(
  [Parameter(Mandatory=$false)][string]$RepoRoot = (Get-Location).Path
)

$ErrorActionPreference = "Stop"

$contractPath = Join-Path $RepoRoot ".gate/contract/contract.json"
if (-not (Test-Path -LiteralPath $contractPath)) { throw "contract.json not found: $contractPath" }

$contract = Get-Content -LiteralPath $contractPath -Raw | ConvertFrom-Json

$requiredFiles = @($contract.root_contract.required_root_files)
$allowedFilesExact = @($contract.root_contract.allowed_root_files_exact)
$allowedDots = @($contract.allowed_root_dot_folders)

$bad = New-Object System.Collections.Generic.List[string]

# enumerate root entries (including dot files/folders)
$items = Get-ChildItem -LiteralPath $RepoRoot -Force

foreach ($item in $items) {
  $name = $item.Name

  # ignore '.' and '..'
  if ($name -eq "." -or $name -eq "..") { continue }

  if ($item.PSIsContainer) {
    if (-not $name.StartsWith(".")) {
      $bad.Add("Non-dot folder in root: $name") | Out-Null
      continue
    }

    if ($allowedDots.Count -gt 0) {
      $found = $false
      foreach ($d in $allowedDots) {
        if ($d -eq $name) { $found = $true; break }
      }
      if (-not $found) { $bad.Add("Unexpected dot-folder in root: $name") | Out-Null }
    }
  }
  else {
    $found = $false
    foreach ($f in $allowedFilesExact) {
      if ($f -eq $name) { $found = $true; break }
    }
    if (-not $found) { $bad.Add("Unexpected root file: $name") | Out-Null }
  }
}

foreach ($rf in $requiredFiles) {
  if (-not (Test-Path -LiteralPath (Join-Path $RepoRoot $rf))) {
    $bad.Add("Missing required root file: $rf") | Out-Null
  }
}

if ($bad.Count -gt 0) {
  $markerDir = Join-Path $RepoRoot ".report"
  New-Item -ItemType Directory -Force -Path $markerDir | Out-Null
  New-Item -ItemType File -Force -Path (Join-Path $markerDir "gate-flag-root-contract.fail") | Out-Null

  Write-Host ""
  Write-Host "Root contract FAILED:" -ForegroundColor Red
  foreach ($b in $bad) {
    Write-Host (" - " + $b) -ForegroundColor Red
  }
  Write-Host ""
  exit 2
}

Write-Host "Root contract OK"
