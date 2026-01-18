# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
param(
  [string]$TargetRoot = ".",
  [switch]$DryRun = $false,
  [switch]$Force = $false
)

Set-StrictMode -Version Latest
$ErrorActionPreference = "Stop"

$ScriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$PackDir = Join-Path $ScriptDir "..\pack" | Resolve-Path

$TargetRoot = Resolve-Path $TargetRoot

function Write-Info([string]$msg) { Write-Host $msg }
function Write-Err([string]$msg) { Write-Host $msg -ForegroundColor Red }

if (-not (Test-Path (Join-Path $TargetRoot "composer.json"))) {
  Write-Err "composer.json not found in TargetRoot. Run from project root or pass -TargetRoot."
  exit 2
}

$copyList = @(
  "src",
  "templates",
  "config",
  "docs",
  "tools"
)

foreach ($item in $copyList) {
  $srcPath = Join-Path $PackDir $item
  if (-not (Test-Path $srcPath)) { continue }
  $dstPath = Join-Path $TargetRoot $item

  $files = Get-ChildItem -Path $srcPath -Recurse -File
  foreach ($f in $files) {
    $rel = $f.FullName.Substring($srcPath.Path.Length).TrimStart('\','/')
    $dst = Join-Path $dstPath $rel
    $dstDir = Split-Path -Parent $dst
    if (-not (Test-Path $dstDir)) {
      if (-not $DryRun) { New-Item -ItemType Directory -Force -Path $dstDir | Out-Null }
      Write-Info "mkdir $dstDir"
    }

    if (Test-Path $dst) {
      $srcHash = (Get-FileHash -Algorithm SHA256 $f.FullName).Hash
      $dstHash = (Get-FileHash -Algorithm SHA256 $dst).Hash
      if ($srcHash -ne $dstHash) {
        if (-not $Force) {
          Write-Err "Conflict: $dst"
          Write-Err "Use -Force to overwrite or remove the file manually."
          exit 3
        }
      } else {
        continue
      }
    }

    if (-not $DryRun) { Copy-Item -Force -Path $f.FullName -Destination $dst }
    Write-Info "copy $($f.FullName) -> $dst"
  }
}

Write-Info "OK. If your project does not auto-import config/routes/*.yaml or config/services/*.yaml, import the provided files manually."
