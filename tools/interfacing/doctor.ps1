$ErrorActionPreference = "Stop"

if (-not (Test-Path "bin/console")) { throw "bin/console not found (run from Symfony app root)" }

php bin/console interfacing:doctor
