param(
    [string] $ProjectRoot = (Resolve-Path (Join-Path $PSScriptRoot '..\..')).Path
)

$ErrorActionPreference = 'Stop'
$script = Join-Path $ProjectRoot 'tools\interfacing\admin-body-runtime-smoke.mjs'
if (-not (Test-Path -LiteralPath $script)) {
    throw "Missing Interfacing admin body runtime smoke harness: $script"
}

node $script
