param(
    [string]$PhpBin = "php"
)

$ErrorActionPreference = "Stop"

& $PhpBin "-d" "memory_limit=512M" "bin/phpunit" `
  "tests/Functional/Interfacing/InterfacingBillingAndOrderScreenTest.php"
