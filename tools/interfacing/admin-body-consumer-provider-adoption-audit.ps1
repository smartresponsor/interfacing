param(
    [string[]]$ConsumerRoot = @(),
    [ValidateSet('text', 'markdown')]
    [string]$Format = 'text',
    [string]$Output = '',
    [switch]$Strict
)

$ErrorActionPreference = 'Stop'
$ScriptDirectory = Split-Path -Parent $MyInvocation.MyCommand.Path
$ProjectRoot = Split-Path -Parent (Split-Path -Parent $ScriptDirectory)
$Tool = Join-Path $ProjectRoot 'tools/interfacing/admin-body-consumer-provider-adoption-audit.php'

if (-not (Test-Path -LiteralPath $Tool)) {
    throw "Missing Interfacing consumer adoption audit tool: $Tool"
}

$arguments = @($Tool, "--format=$Format")
foreach ($root in $ConsumerRoot) {
    $arguments += "--consumer-root=$root"
}
if ($Output -ne '') {
    $arguments += "--output=$Output"
}
if ($Strict.IsPresent) {
    $arguments += '--strict'
}

& php @arguments
if ($LASTEXITCODE -ne 0) {
    throw "Interfacing visible page provider adoption audit failed with exit code $LASTEXITCODE"
}
