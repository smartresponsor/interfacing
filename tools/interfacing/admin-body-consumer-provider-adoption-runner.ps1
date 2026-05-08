param(
    [string[]] $ConsumerRoot = @(),
    [switch] $Defaults,
    [switch] $Strict,
    [switch] $RequireExisting,
    [string] $Format = 'markdown',
    [string] $Output = 'var/interfacing-visible-page-provider-adoption-runner.md'
)

$ErrorActionPreference = 'Stop'
$ScriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$ProjectRoot = Split-Path -Parent (Split-Path -Parent $ScriptDir)
Set-Location $ProjectRoot

$argsList = @('tools/interfacing/admin-body-consumer-provider-adoption-runner.php')
foreach ($root in $ConsumerRoot) {
    $argsList += "--consumer-root=$root"
}
if ($Defaults) { $argsList += '--defaults' }
if ($Strict) { $argsList += '--strict' }
if ($RequireExisting) { $argsList += '--require-existing' }
$argsList += "--format=$Format"
if ($Output -ne '') { $argsList += "--output=$Output" }

& php @argsList
if ($LASTEXITCODE -ne 0) {
    throw "Interfacing visible page provider adoption runner failed with exit code $LASTEXITCODE."
}
