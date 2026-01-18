#!/usr/bin/env bash
set -euo pipefail

PHP_BIN="${PHP_BIN:-php}"

"${PHP_BIN}" -d memory_limit=512M bin/phpunit \
  tests/Functional/Interfacing/InterfacingBillingAndOrderScreenTest.php
