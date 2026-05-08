param(
    [string[]] $ConsumerRoot = @("../Cataloging", "../Cruding", "../Vendoring"),
    [switch] $Apply,
    [switch] $IncludeMacros,
    [string] $Format = "markdown",
    [string] $Output = "var/interfacing-consumer-provider-migration-executor.md"
)

$ErrorActionPreference = "Stop"

$ArgsList = @()
foreach ($Root in $ConsumerRoot) {
    $ArgsList += "--consumer-root=$Root"
}
if ($Apply) {
    $ArgsList += "--apply"
}
if ($IncludeMacros) {
    $ArgsList += "--include-macros"
}
$ArgsList += "--format=$Format"
if ($Output -ne "") {
    $ArgsList += "--output=$Output"
}

php tools/interfacing/admin-body-consumer-provider-migration-executor.php @ArgsList
