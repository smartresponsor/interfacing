#!/usr/bin/env bash
set -euo pipefail

if [ ! -f "bin/console" ]; then
  echo "bin/console not found (run from Symfony app root)"
  exit 1
fi

php tools/interfacing/namespace-guard.php

php bin/console interfacing:doctor
