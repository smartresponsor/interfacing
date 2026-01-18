#!/usr/bin/env bash
set -euo pipefail

if [ ! -f "bin/console" ]; then
  echo "bin/console not found (run from Symfony app root)"
  exit 1
fi

php bin/console interfacing:doctor
