# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
# Simple syntax smoke for the Interfacing domain files.
param(
  [string]$Root = "."
)

$ErrorActionPreference = "Stop"

$php = Get-Command php -ErrorAction SilentlyContinue
if (-not $php) { throw "php is not found in PATH" }

$files = Get-ChildItem -Path $Root -Recurse -File -Filter *.php | Where-Object { $_.FullName -notmatch '\\vendor\\' }
if ($files.Count -eq 0) { throw "No PHP files found under $Root" }

$bad = 0
foreach ($f in $files) {
  $p = $f.FullName
  $out = & php -l $p 2>&1
  if ($LASTEXITCODE -ne 0) {
    Write-Host $out
    $bad++
  }
}

if ($bad -gt 0) { throw "Smoke failed: $bad file(s) have syntax errors" }
Write-Host "Smoke OK: $($files.Count) file(s) checked"
